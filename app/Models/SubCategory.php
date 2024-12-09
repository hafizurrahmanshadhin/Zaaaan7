<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    /**
     * Define the inverse one-to-many relationship with the User model.
     * Indicates that this model belongs to a specific user.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Define the inverse one-to-many relationship with the Category model.
     * Indicates that this model belongs to a single category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
