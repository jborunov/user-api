<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'country_code',
        'ip_address',
    ];

    protected $appends = ['country_name', 'ip_address_sum'];
    protected $hidden = ['country_code', 'ip_address', 'created_at', 'updated_at'];
    protected $casts = [];

    protected static $countryCache = null;

    /**
     * Get the user's first name.
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            //capitalize the first letter of the first name
            get: fn (string $value) => $value ? ucfirst($value) : "No first name",
            set: fn (string $value) => strtolower($value),
        );
    }

    /**
     * Get the user's last name.
     */
    protected function lastName(): Attribute
    {
        return Attribute::make(
            //capitalize the first letter of the last name and reverse it
            get: fn (string $value) => $value ? strrev(ucfirst($value)) : "No last name",
            set: fn (string $value) => strtolower($value),
        );
    }

    /**
     * Get the user's country code.
     */
    protected function countryCode(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }

    /**
     * Get the user's country name, including cache to make sure we read the config file less times if they reapeat.
     */
    public function getCountryNameAttribute(): string
    {
        if (self::$countryCache === null) {
            self::$countryCache = config('countries');
        }
        return self::$countryCache[$this->country_code] ?? 'Unknown';
    }

    /**
     * Get the user's Ip Adress Sum.
     * This will sum the 4 octets of the IP address and return the result.
     * If the logic is slowing down on big data, it can be moved to store the result in database on adding/updating a user, not to do the math every time.
     */
    public function getIpAddressSumAttribute(): int
    {
        return $this->ip_address ? array_sum(explode('.', $this->ip_address)) : 0;
    }
}
