<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $primaryKey = 'ClassID';

    public $timestamps = false;

    protected $fillable = [
        'SubjectCode',
        'FacultyID',
        'SchoolYear',
        'Semester',
        'Day',
        'Time',
        'Room',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'SubjectCode', 'SubjectCode');
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'FacultyID', 'FacultyID');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'ClassID', 'ClassID');
    }
}