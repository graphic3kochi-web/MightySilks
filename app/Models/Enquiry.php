<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table('enquiries')]
#[Guarded(['id'])]
class Enquiry extends Model
{
    public const STATUSES = ['new' => 'New', 'quoted' => 'Quoted', 'closed' => 'Closed'];

    protected function casts(): array
    {
        return ['needed_by' => 'date'];
    }
}
