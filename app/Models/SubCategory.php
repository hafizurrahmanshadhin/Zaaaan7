<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubCategory extends Model
{
    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
