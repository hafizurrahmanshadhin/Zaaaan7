<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['url'];

    /**
     * Define a polymorphic relationship.
     * Indicates that this model can belong to multiple other models (e.g., User, Post) as an imageable entity.
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }


/**
     * Get the URL attribute.
     *
     * This accessor method modifies the URL based on its type:
     * - If the URL starts with 'http://' or 'https://', it appends the string 'tushar' to the URL.
     * - If the URL is a relative path, it prepends the base URL using the asset helper.
     * - If the URL is null, it returns the default user image URL.
     *
     * @param string|null $url The URL to be processed. Can be null or a string.
     *
     * @return string The processed URL. It may be modified or default to a fallback image.
     */
    public function getUrlAttribute($url): string
    {
        if ($url) {
            if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
                return $url;
            } else {
                return asset('storage/' . $url);
            }
        } else {
            return asset('assets/custom/img/user.jpg');
        }
    }
}
