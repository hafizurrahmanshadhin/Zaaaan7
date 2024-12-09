<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    protected $guarded = [];
    /**
     * Define a polymorphic one-to-many relationship with the Image model.
     * Indicates that this model can have multiple associated images.
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Define the inverse one-to-many relationship with the User model for the 'client' role.
     * Indicates that this task belongs to a specific client (user).
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client');
    }

    /**
     * Define the inverse one-to-many relationship with the User model for the 'helper' role.
     * Indicates that this task belongs to a specific helper (user).
     */
    public function helper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'helper');
    }

    /**
     * Define the many-to-many relationship with the User model through 'task_requests'.
     * Indicates that multiple users can request to participate in this task.
     */
    public function requests()
    {
        return $this->belongsToMany(User::class, 'task_requests')
            ->withTimestamps();
    }

}
