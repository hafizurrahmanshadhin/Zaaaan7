<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    /**
     * Define the one-to-many relationship with the SubCategory model.
     * Indicates that this model can have multiple subcategories.
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
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
                return asset($url);
            }
        } else {
            return asset('assets/custom/img/user.jpg');
        }
    }
}
