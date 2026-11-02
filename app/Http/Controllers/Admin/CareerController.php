<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOpening;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/** Open roles for /careers / /career-details. */
class CareerController extends Controller
{
    public function index()
    {
        return view('admin.careers.index', [
            'openings' => JobOpening::withCount('applications')->orderBy('position')->get(),
            'offer' => Setting::get('job_offer'),
        ]);
    }

    public function create()
    {
        return view('admin.careers.form', ['job' => new JobOpening(['is_open' => true, 'type' => 'Full-time', 'location' => 'Dubai, UAE'])]);
    }

    public function edit(JobOpening $career)
    {
        return view('admin.careers.form', ['job' => $career]);
    }

    public function store(Request $request)
    {
        $this->save($request, new JobOpening(['position' => (int) JobOpening::max('position') + 1]));

        return redirect()->route('admin.careers.index')->with('status', 'Role added.');
    }

    public function update(Request $request, JobOpening $career)
    {
        $this->save($request, $career);

        return redirect()->route('admin.careers.index')->with('status', "{$career->title} saved.");
    }

    public function destroy(JobOpening $career)
    {
        $career->delete();

        return redirect()->route('admin.careers.index')->with('status', "{$career->title} removed.");
    }

    private function save(Request $request, JobOpening $job): void
    {
        $data = $request->validate([
            'title' => 'required|string|max:120',
            'slug' => ['nullable', 'regex:/^[a-z0-9-]+$/', 'max:120', Rule::unique('job_openings', 'slug')->ignore($job->id)],
            'department' => 'required|string|max:80',
            'location' => 'required|string|max:80',
            'type' => 'required|string|max:40',
            'experience' => 'required|string|max:40',
            'summary' => 'required|string|max:2000',
            'responsibilities' => 'required|string',
            'requirements' => 'required|string',
            'offer' => 'nullable|string',
            'is_open' => 'boolean',
        ]);
        // One item per line; leading "-" or "•" bullets are dropped.
        $lines = fn (?string $text) => array_values(array_filter(array_map(fn ($l) => trim(preg_replace('/^[\s\-•]+/u', '', $l)), explode("\n", (string) $text)))) ?: null;

        $job->fill([
            ...$data,
            'slug' => ($data['slug'] ?? null) ?: ($job->slug ?? $this->uniqueSlug(Str::slug($data['title']))),
            'responsibilities' => $lines($data['responsibilities']),
            'requirements' => $lines($data['requirements']),
            'offer' => $lines($data['offer'] ?? null),
        ])->save();
    }

    /** "store-manager", or "store-manager-2"… when a role already has it. */
    private function uniqueSlug(string $slug): string
    {
        for ($i = 2, $try = $slug; JobOpening::where('slug', $try)->exists(); $i++) {
            $try = "$slug-$i";
        }

        return $try;
    }
}
