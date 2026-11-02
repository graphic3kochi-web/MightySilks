<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\JobApplication;
use App\Models\JobOpening;
use App\Models\Product;
use App\Models\Review;
use App\Models\Subscriber;
use Illuminate\Http\Request;

/** What visitors send in: newsletter, corporate enquiries, job applications and reviews. */
class FormController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate(['email' => 'required|email|max:120', 'source' => 'nullable|string|max:30']);
        Subscriber::firstOrCreate(['email' => strtolower($data['email'])], ['source' => $data['source'] ?? null]);

        return ['ok' => true];
    }

    /** corporate-bulk.html */
    public function enquiry(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'company' => 'nullable|string|max:120',
            'email' => 'required|email|max:120',
            'phone' => 'required|string|max:30',
            'type' => 'required|string|max:80',
            'quantity' => 'required|integer|min:10|max:100000',
            'budget' => 'nullable|string|max:80',
            'date' => 'nullable|date',
            'message' => 'nullable|string|max:3000',
        ]);

        Enquiry::create([
            'type' => 'bulk',
            'name' => $data['name'],
            'company' => $data['company'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'order_type' => $data['type'],
            'quantity' => $data['quantity'],
            'budget' => $data['budget'] ?? null,
            'needed_by' => $data['date'] ?? null,
            'message' => $data['message'] ?? null,
        ]);

        return ['ok' => true];
    }

    /** contact.html: kept with the enquiries, the topic as its order type. */
    public function contact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:120',
            'phone' => 'nullable|string|max:30',
            'order' => 'nullable|string|max:32',
            'subject' => 'required|string|max:80',
            'message' => 'required|string|max:3000',
        ]);

        Enquiry::create([
            'type' => 'contact',
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? '',
            'order_type' => $data['subject'],
            'message' => ($data['order'] ?? null) ? "Order #{$data['order']}\n\n{$data['message']}" : $data['message'],
        ]);

        return ['ok' => true];
    }

    /** careers.html / career-details.html: the CV is kept privately (storage/app/private/cvs). */
    public function apply(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:120',
            'phone' => 'required|string|max:30',
            'position' => 'required|string|max:120',
            'message' => 'nullable|string|max:3000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ], ['cv.mimes' => 'Your CV should be a PDF or Word file.', 'cv.max' => 'Your CV is larger than 5 MB. Please attach a smaller file.']);

        JobApplication::create([
            'job_opening_id' => JobOpening::where('title', $data['position'])->value('id'),
            'position' => $data['position'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message' => $data['message'] ?? null,
            'cv_path' => $request->file('cv')->store('cvs'),
            'cv_name' => $request->file('cv')->getClientOriginalName(),
        ]);

        return ['ok' => true];
    }

    /** product.html's Write a Review: held for approval. */
    public function review(Request $request)
    {
        $data = $request->validate([
            'product' => 'required|string|max:40',
            'rating' => 'required|integer|between:1,5',
            'title' => 'nullable|string|max:120',
            'review' => 'required|string|max:3000',
            'name' => 'required|string|max:80',
        ]);

        Review::create([
            'product_id' => Product::where('code', $data['product'])->value('id'),
            'user_id' => $request->user()?->id,
            'rating' => $data['rating'],
            'title' => $data['title'] ?? null,
            'body' => $data['review'],
            'name' => $data['name'],
        ]);

        return ['ok' => true];
    }
}
