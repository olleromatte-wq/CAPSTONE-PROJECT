<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $table = 'students';

    protected $primaryKey = 'StudentID';

    public $timestamps = false;

    protected $fillable = [
        'UserID',
        'ProgramID',
        'FirstName',
        'LastName',
        'YearLevel',
    ];

    protected $casts = [
        'YearLevel' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'ProgramID', 'ProgramID');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'StudentID', 'StudentID');
    }
}