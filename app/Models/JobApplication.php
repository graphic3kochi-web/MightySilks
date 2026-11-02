<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded(['id'])]
class JobApplication extends Model
{
    public const STATUSES = ['new' => 'New', 'shortlisted' => 'Shortlisted', 'rejected' => 'Rejected', 'hired' => 'Hired'];

    public function opening(): BelongsTo
    {
        return $this->belongsTo(JobOpening::class, 'job_opening_id');
    }
}
