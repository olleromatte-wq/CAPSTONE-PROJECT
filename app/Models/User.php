<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $primaryKey = 'UserID';

    public $timestamps = false;

    protected $fillable = [
        'Username_Email',
        'PasswordHash',
        'Role',
        'IsActive',
    ];

    protected $hidden = [
        'PasswordHash',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
    ];

    public function getAuthPassword()
    {
        return $this->PasswordHash;
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'UserID', 'UserID');
    }

    public function faculty(): HasOne
    {
        return $this->hasOne(Faculty::class, 'UserID', 'UserID');
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'AuthorID', 'UserID');
    }
}