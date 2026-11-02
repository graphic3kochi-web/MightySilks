<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.subscribers.index', [
            'subscribers' => Subscriber::when($request->q, fn ($q, $term) => $q->where('email', 'like', "%$term%"))->latest()->paginate(30)->withQueryString(),
            'total' => Subscriber::count(),
        ]);
    }

    /** Every subscriber as a CSV, for the mailing tool. */
    public function export()
    {
        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['email', 'source', 'subscribed_at']);
            Subscriber::orderBy('id')->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $row) {
                    fputcsv($out, [$row->email, $row->source, $row->created_at->toDateTimeString()]);
                }
            });
            fclose($out);
        }, 'subscribers-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv']);
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('status', "{$subscriber->email} removed.");
    }
}
