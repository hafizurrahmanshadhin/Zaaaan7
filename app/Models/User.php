<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

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
     * Define the one-to-many relationship with the Review model.
     * A user can have multiple reviews.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Define the one-to-many relationship with the Task model as a client.
     * A user can create multiple tasks as a client.
     */
    public function clientTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'client');
    }

    /**
     * Define the one-to-many relationship with the Task model as a helper.
     * A user can be assigned multiple tasks as a helper.
     */
    public function helperTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'helper');
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
     * Define an accessor for the user's avatar.
     * Returns a default avatar image if the user doesn't have one.
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset($value) : asset('assets/custom/img/user.jpg'),
        );
    }
}
