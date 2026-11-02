@extends('layouts.admin')

@section('title', $job->exists ? $job->title : 'Add Role')
@section('crumb', $job->exists ? 'Edit Role' : 'Add Role')

@section('content')
@php $lines = fn ($items) => implode(PHP_EOL, (array) $items); @endphp
<div class="adm-head">
  <h1>{{ $job->exists ? $job->title : 'Add Role' }}</h1>
  @if ($job->exists)
    <div class="adm-head__actions">
      <form method="post" action="{{ route('admin.careers.destroy', $job) }}" data-confirm="Remove this role? Its applications are kept.">@csrf @method('delete')<button class="adm-btn adm-btn--danger" type="submit"><i class="fa-solid fa-trash"></i> Remove</button></form>
    </div>
  @endif
</div>

<form class="adm-form" method="post" action="{{ $job->exists ? route('admin.careers.update', $job) : route('admin.careers.store') }}">
  @csrf
  @if ($job->exists) @method('put') @endif
  <section class="adm-card">
    <div class="adm-grid">
      <x-admin.field name="title" label="Role" :value="$job->title" required wide />
      <x-admin.field name="summary" label="Summary" type="textarea" rows="4" :value="$job->summary" required wide />
      <x-admin.field name="responsibilities" label="Responsibilities" type="textarea" rows="6" :value="$lines($job->responsibilities)" required help="One per line." wide />
      <x-admin.field name="requirements" label="Requirements" type="textarea" rows="6" :value="$lines($job->requirements)" required help="One per line." wide />
      <x-admin.field name="offer" label="What we offer (this role only)" type="textarea" rows="4" :value="$lines($job->offer)" help="One per line. Empty: the shared benefits from Settings." wide />
    </div>
  </section>
  <div>
    <section class="adm-card">
      <div class="adm-grid" style="grid-template-columns:1fr">
        <x-admin.check name="is_open" label="Open for applications" :checked="$job->is_open" />
        <x-admin.field name="department" label="Department" :value="$job->department" required />
        <x-admin.field name="location" label="Location" :value="$job->location" required />
        <x-admin.field name="type" label="Type" :value="$job->type" required />
        <x-admin.field name="experience" label="Experience" :value="$job->experience" required />
        <x-admin.field name="slug" label="Address" :value="$job->slug" help="career-details.html?job=address. Empty: made from the role." />
      </div>
    </section>
    <div class="adm-form__bar">
      <a class="adm-btn adm-btn--ghost" href="{{ route('admin.careers.index') }}">Cancel</a>
      <button class="adm-btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save Role</button>
    </div>
  </div>
</form>
@endsection
