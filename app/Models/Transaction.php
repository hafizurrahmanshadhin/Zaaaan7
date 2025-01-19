<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $guarded = [];

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

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
