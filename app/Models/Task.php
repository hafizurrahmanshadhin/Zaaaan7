<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    
    public function images():MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function client():BelongsTo
    {
        return $this->belongsTo(User::class, 'client');
    }


    public function helper():BelongsTo
    {
        return $this->belongsTo(User::class, 'helper');
    }


    public function requests()
    {
        return $this->belongsToMany(User::class, 'task_requests')
                    ->withTimestamps();
    }
}
