<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with('product')
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'counts' => Review::selectRaw('status, COUNT(*) c')->groupBy('status')->pluck('c', 'status'),
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $review->update($request->validate(['status' => ['required', Rule::in(array_keys(Review::STATUSES))]]));

        return back()->with('status', "Review by {$review->name} ".strtolower(Review::STATUSES[$review->status]).'.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('status', 'Review deleted.');
    }
}
