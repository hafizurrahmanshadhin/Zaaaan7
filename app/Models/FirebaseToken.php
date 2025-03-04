<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FirebaseToken extends Model {
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    protected function casts(): array {
        return [
            'user_id'   => 'integer',
            'token'     => 'string',
            'device_id' => 'string',
            'status'    => 'string',
        ];
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
