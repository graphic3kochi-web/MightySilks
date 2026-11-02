@extends('layouts.admin')

@section('title', 'Applications')
@section('crumb', 'Applications')

@section('content')
<div class="adm-head">
  <div>
    <h1>Applications</h1>
    <p>Sent from the Careers pages, with CVs</p>
  </div>
</div>

<section class="adm-card">
  <form class="adm-filters" method="get">
    <select name="status" aria-label="Status" onchange="this.form.submit()">
      <option value="">All statuses ({{ $counts->sum() }})</option>
      @foreach (\App\Models\JobApplication::STATUSES as $key => $label)
        <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }} ({{ $counts[$key] ?? 0 }})</option>
      @endforeach
    </select>
    <select name="job" aria-label="Role" onchange="this.form.submit()">
      <option value="">All roles</option>
      @foreach ($openings as $id => $title)
        <option value="{{ $id }}" @selected((string) request('job') === (string) $id)>{{ $title }}</option>
      @endforeach
    </select>
  </form>
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead><tr><th>Applicant</th><th>Role</th><th>Status</th><th>Received</th><th></th></tr></thead>
      <tbody>
        @forelse ($applications as $application)
          <tr>
            <td><a href="{{ route('admin.applications.show', $application) }}">{{ $application->name }}</a><br><span class="muted">{{ $application->email }} · {{ $application->phone }}</span></td>
            <td>{{ $application->position }}</td>
            <td><span class="adm-badge adm-badge--{{ $application->status }}">{{ \App\Models\JobApplication::STATUSES[$application->status] }}</span></td>
            <td>{{ $application->created_at->format('d M Y') }}</td>
            <td><div class="adm-actions"><a class="adm-btn adm-btn--ghost adm-btn--sm" href="{{ route('admin.applications.cv', $application) }}"><i class="fa-solid fa-download"></i> CV</a></div></td>
          </tr>
        @empty
          <tr><td colspan="5" class="adm-empty">No applications here.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $applications->links() }}
</section>
@endsection
