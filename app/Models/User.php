<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }



    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * Define the relationship between the current model and the Profile model.
     *
     * This method defines a "has one" relationship, where the current model
     * has one associated Profile. The foreign key for this relationship is
     * expected to be present in the Profile model's table (typically `user_id`).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }


    /**
     * Define the relationship between the current model and the Otp model.
     *
     * This method defines a "has many" relationship, where the current model
     * can have multiple associated OTP (One-Time Password) entries. The foreign key
     * for this relationship is expected to be present in the Otp model's table
     * (typically `user_id` or a relevant identifier).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function otps(): HasMany
    {
        return $this->hasMany(OTP::class);
    }

    /**
     * Define the one-to-many relationship with the Address model.
     * A user can have multiple addresses.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Define the many-to-many relationship with the SubCategory model.
     * A user can have multiple skills that belong to various subcategories.
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(SubCategory::class);
    }

    /**
     * Define the one-to-many relationship with the Task model as a client.
     * A user can create multiple tasks as a client.
     */
    public function clientTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'client');
    }


    public function clientTransections(): HasMany
    {
        return $this->hasMany(Transaction::class, 'client');
    }

    /**
     * Define the one-to-many relationship with the Task model as a helper.
     * A user can be assigned multiple tasks as a helper.
     */
    public function helperTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'helper');
    }


    public function helperTransections(): HasMany
    {
        return $this->hasMany(Transaction::class, 'helper');
    }

    /**
     * Define the many-to-many relationship with the Task model through 'task_requests'.
     * A user can request to participate in multiple tasks.
     */
    public function requests()
    {
        return $this->belongsToMany(Task::class, 'task_requests')
            ->withTimestamps();
    }

    /**
     * Define the one-to-one relationship with the UserDocument model for ID cards.
     * Fetches only documents of type 'id'.
     */
    public function idCard(): HasOne
    {
        return $this->hasOne(UserDocument::class)
            ->where('type', 'id');  // Only fetch 'id' type documents
    }

    /**
     * Define the one-to-many relationship with the UserDocument model for documents.
     * Fetches only documents of type 'document'.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(UserDocument::class)
            ->where('type', 'document');  // Only fetch 'document' type documents
    }

    /**
     * Retrieve the reviews where the user is the client.
     *
     * This method defines a one-to-many-through relationship between the user and the reviews, where the user is the client
     * in the related tasks. It will return all reviews associated with the tasks where the user is the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientReviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, Task::class, 'client', 'task_id', 'id', 'id')
            ->orWhereHas('task', function ($query) {
                $query->where('helper', $this->id);
            });
    }


    /**
     * Retrieve the reviews where the user is the helper.
     *
     * This method defines a one-to-many-through relationship between the user and the reviews, where the user is the helper
     * in the related tasks. It will return all reviews associated with the tasks where the user is the helper.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function helperReviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, Task::class, 'helper', 'task_id', 'id', 'id')
            ->orWhereHas('task', function ($query) {
                $query->where('helper', $this->id);
            });
    }

    /**
     * Get the avatar attribute.
     *
     * @param string|null $url The URL to be processed. Can be null or a string.
     *
     * @return string The processed URL. It may be modified or default to a fallback image.
     */
    public function getAvatarAttribute($url): string
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


    /**
     * Calculate the average rating for a helper based on reviews.
     *
     * This method calculates the average rating for a helper by retrieving the average value of the `star` field
     * from all associated reviews in the `helper_reviews` relationship. It is assumed that each review contains a
     * `star` rating representing the helper's performance.
     *
     * @return float The average star rating for the helper. If no reviews exist, it will return `null`.
     */
    public function avarageRating()
    {
        return $this->helperReviews()->average('star') ?? 0;
    }
}
