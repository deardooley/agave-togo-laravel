<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SocialAccount.
 */
class SocialAccount extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'social_accounts';

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'provider', 'provider_id', 'token', 'refresh_token', 'avatar'];


    public function scopeByUserProvider(Builder $query, int $userId, string $provider) {
        return $query->where('user_id', $userId)->where('provider', $provider);
    }
}
