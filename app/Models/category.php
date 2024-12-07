<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Category extends Model
{
    protected $guarded = [];
    /**
     * Define the one-to-many relationship with the SubCategory model.
     * Indicates that this model can have multiple subcategories.
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    public function image(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
