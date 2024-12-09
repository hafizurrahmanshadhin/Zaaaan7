<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDocument extends Model
{
    protected $guarded = [];
    /**
     * Define the inverse one-to-many relationship with the User model.
     * Indicates that this model belongs to a specific user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
