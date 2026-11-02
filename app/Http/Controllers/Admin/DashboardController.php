<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\JobApplication;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public const WEEKS = 12;

    public function index()
    {
        $since = now()->subDays(30);
        $before = now()->subDays(60);
        $sold = fn () => Order::where('status', '!=', 'cancelled');

        $revenue = (float) $sold()->where('created_at', '>=', $since)->sum('total');
        $revenuePrev = (float) $sold()->whereBetween('created_at', [$before, $since])->sum('total');
        $orders = $sold()->where('created_at', '>=', $since)->count();
        $ordersPrev = $sold()->whereBetween('created_at', [$before, $since])->count();
        $customers = User::where('is_admin', false);
        $newCustomers = (clone $customers)->where('created_at', '>=', $since)->count();
        $newCustomersPrev = (clone $customers)->whereBetween('created_at', [$before, $since])->count();
        $statusCounts = Order::selectRaw('status, COUNT(*) c')->groupBy('status')->pluck('c', 'status');

        $weeks = $this->weekStarts();
        $activity = [
            'labels' => $weeks->map(fn (Carbon $w) => $w->format('d M'))->all(),
            'orders' => $this->weekly(Order::query(), $weeks),
            'signups' => $this->weekly(User::where('is_admin', false), $weeks),
            'reviews' => $this->weekly(Review::query(), $weeks),
        ];

        $stats = [
            'customers' => [
                'total' => (clone $customers)->count(),
                'new' => $newCustomers,
                'blocked' => (clone $customers)->where('status', 'blocked')->count(),
                'trend' => $this->trend($newCustomers, $newCustomersPrev),
                'spark' => $activity['signups'],
            ],
            'awaiting' => [
                'placed' => $statusCounts['placed'] ?? 0,
                'packed' => $statusCounts['packed'] ?? 0,
            ],
            'products' => [
                'active' => Product::active()->count(),
                'new' => Product::active()->where('is_new', true)->count(),
                'low' => Product::active()->where('stock', '<=', 3)->count(),
                'in_stock' => Product::active()->where('stock', '>', 0)->count(),
            ],
            'orders' => [
                'count' => $orders,
                'delivered' => Order::where('created_at', '>=', $since)->where('status', 'delivered')->count(),
                'trend' => $this->trend($orders, $ordersPrev),
                'spark' => $activity['orders'],
            ],
            'revenue' => [
                'total' => $revenue,
                'average' => $orders ? $revenue / $orders : 0,
                'trend' => $this->trend($revenue, $revenuePrev),
                'spark' => $this->weekly($sold(), $weeks, 'created_at', 'SUM(total)'),
            ],
            'subscribers' => [
                'total' => Subscriber::count(),
                'new' => Subscriber::where('created_at', '>=', $since)->count(),
            ],
        ];

        $attention = [
            ['fa-box', $stats['awaiting']['placed'], 'orders waiting to be packed', 'Review', route('admin.orders.index', ['status' => 'placed'])],
            ['fa-star', Review::where('status', 'pending')->count(), 'reviews awaiting approval', 'Moderate', route('admin.reviews.index', ['status' => 'pending'])],
            ['fa-envelope-open-text', Enquiry::where('status', 'new')->count(), 'new bulk enquiries', 'Read', route('admin.enquiries.index', ['status' => 'new'])],
            ['fa-file-lines', JobApplication::where('status', 'new')->count(), 'new job applications', 'Open', route('admin.applications.index', ['status' => 'new'])],
            ['fa-triangle-exclamation', $stats['products']['low'], 'products low on stock', 'View', route('admin.products.index', ['stock' => 'low'])],
        ];

        // Last 90 days: what sells (by category) and how people pay.
        $quarter = now()->subDays(90);
        $byCategory = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.status', '!=', 'cancelled')->where('orders.created_at', '>=', $quarter)
            ->selectRaw('products.category, SUM(order_items.price * order_items.qty) revenue, SUM(order_items.qty) units')
            ->groupBy('products.category')->orderByDesc('revenue')->get();
        $payments = Order::where('created_at', '>=', $quarter)
            ->selectRaw('payment_method, COUNT(*) c')->groupBy('payment_method')->pluck('c', 'payment_method');

        return view('admin.dashboard', [
            'revenue' => $revenue,
            'orders' => $orders,
            'newCustomers' => $newCustomers,
            'enquiries30' => Enquiry::where('created_at', '>=', $since)->count(),
            'open' => ($statusCounts['placed'] ?? 0) + ($statusCounts['packed'] ?? 0) + ($statusCounts['shipped'] ?? 0),
            'paid' => $sold()->where('created_at', '>=', $since)->where('payment_status', 'paid')->count(),
            'stats' => $stats,
            'activity' => $activity,
            'attention' => $attention,
            'waiting' => collect($attention)->sum(1),
            'latestCustomers' => User::where('is_admin', false)->latest()->take(3)->get(),
            'statusCounts' => $statusCounts,
            'byCategory' => $byCategory,
            'payments' => $payments,
            'recentOrders' => Order::withCount('items')->latest()->take(6)->get(),
        ]);
    }

    private function weekStarts()
    {
        $first = now()->startOfWeek()->subWeeks(self::WEEKS - 1);

        return collect(range(0, self::WEEKS - 1))->map(fn ($i) => $first->copy()->addWeeks($i));
    }

    /** Per-week totals (a count, or $aggregate) for the last WEEKS weeks, oldest first. */
    private function weekly(Builder $query, $weeks, string $column = 'created_at', string $aggregate = 'COUNT(*)'): array
    {
        $days = $query->where($column, '>=', $weeks->first())
            ->selectRaw("DATE($column) d, $aggregate v")->groupByRaw("DATE($column)")->pluck('v', 'd');
        $totals = array_fill(0, self::WEEKS, 0);
        foreach ($days as $day => $value) {
            $i = (int) floor($weeks->first()->diffInDays(Carbon::parse($day)) / 7);
            if ($i >= 0 && $i < self::WEEKS) {
                $totals[$i] += (float) $value;
            }
        }

        return $totals;
    }

    private function trend(float $now, float $before): ?int
    {
        return $before ? (int) round(($now - $before) / $before * 100) : null;
    }
}
