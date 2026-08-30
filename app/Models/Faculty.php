<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    protected $table = 'faculty';

    protected $primaryKey = 'FacultyID';

    public $timestamps = false;

    protected $fillable = [
        'UserID',
        'DepartmentID',
        'FirstName',
        'LastName',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'DepartmentID', 'DepartmentID');
    }

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'FacultyID', 'FacultyID');
    }
}