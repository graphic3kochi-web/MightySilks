<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Corporate & bulk enquiries (corporate-bulk.html). */
class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.enquiries.index', [
            'enquiries' => Enquiry::when($request->status, fn ($q, $status) => $q->where('status', $status))->latest()->paginate(20)->withQueryString(),
            'counts' => Enquiry::selectRaw('status, COUNT(*) c')->groupBy('status')->pluck('c', 'status'),
        ]);
    }

    public function show(Enquiry $enquiry)
    {
        return view('admin.enquiries.show', ['enquiry' => $enquiry]);
    }

    public function update(Request $request, Enquiry $enquiry)
    {
        $enquiry->update($request->validate(['status' => ['required', Rule::in(array_keys(Enquiry::STATUSES))]]));

        return back()->with('status', "Enquiry from {$enquiry->name} marked ".strtolower(Enquiry::STATUSES[$enquiry->status]).'.');
    }
}
