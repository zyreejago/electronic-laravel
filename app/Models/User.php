<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role', // user, technician, admin
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
        ];
    }

    public function technician()
    {
        return $this->hasOne(Technician::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function technicianBookings()
    {
        return $this->hasManyThrough(Booking::class, Technician::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTechnician()
    {
        return $this->role === 'technician';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function routeNotificationForWhatsapp($notification)
    {
        \Log::info('routeNotificationForWhatsapp called', [
            'user_id' => $this->id,
            'phone_number' => $this->phone_number,
        ]);
        return $this->phone_number;
    }
}
