<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/** A shop page's product grid (sarees.html, diwali.html…), in its own order. */
#[Guarded(['id'])]
class Collection extends Model
{
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('position')->orderByPivot('position');
    }
}
