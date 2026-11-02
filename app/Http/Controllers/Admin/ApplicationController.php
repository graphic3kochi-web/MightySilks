<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobOpening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applications = JobApplication::with('opening')
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->when($request->job, fn ($q, $job) => $q->where('job_opening_id', $job))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.applications.index', [
            'applications' => $applications,
            'openings' => JobOpening::orderBy('position')->pluck('title', 'id'),
            'counts' => JobApplication::selectRaw('status, COUNT(*) c')->groupBy('status')->pluck('c', 'status'),
        ]);
    }

    public function show(JobApplication $application)
    {
        return view('admin.applications.show', ['application' => $application]);
    }

    public function update(Request $request, JobApplication $application)
    {
        $application->update($request->validate(['status' => ['required', Rule::in(array_keys(JobApplication::STATUSES))]]));

        return back()->with('status', "{$application->name}: ".JobApplication::STATUSES[$application->status].'.');
    }

    /** The CV is private (storage/app/private), so it's only downloadable from here. */
    public function cv(JobApplication $application)
    {
        abort_unless(Storage::exists($application->cv_path), 404, 'The CV file is missing.');

        return Storage::download($application->cv_path, $application->cv_name);
    }
}
