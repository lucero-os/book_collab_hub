<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    // Define the JWT identifier method
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Define the JWT custom claims method
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roleName)
    {
        return $this->roles->contains('code', $roleName);
    }

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, Role::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_permission_user')->withPivot('permission_id');
    }

    public function hasBookPermission($bookId, $permission)
    {
        return $this->books()->where('book_id', $bookId)->wherePivot('permission_id', Permission::where('code', $permission)->first()->id)->exists();
    }
}
