<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    protected $fillable = ['url'];
    
    /**
     * Define a polymorphic relationship.
     * Indicates that this model can belong to multiple other models (e.g., User, Post) as an imageable entity.
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }


    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn($url) => $url ? asset($url) : asset('assets/custom/img/user.jpg'),
        );
    }
}
