<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded(['id'])]
class JobOpening extends Model
{
    protected function casts(): array
    {
        return [
            'responsibilities' => 'array',
            'requirements' => 'array',
            'offer' => 'array',
            'is_open' => 'boolean',
        ];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /** The js/jobs.js entry career-details.html renders. */
    public function toScript(): array
    {
        return array_filter([
            'title' => $this->title,
            'department' => $this->department,
            'location' => $this->location,
            'type' => $this->type,
            'experience' => $this->experience,
            'summary' => $this->summary,
            'responsibilities' => $this->responsibilities,
            'requirements' => $this->requirements,
            'offer' => $this->offer ?: null,
        ], fn ($v) => $v !== null);
    }
}
