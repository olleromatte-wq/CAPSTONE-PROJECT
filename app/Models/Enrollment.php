<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Enrollment extends Model
{
    protected $table = 'enrollments';

    protected $primaryKey = 'EnrollmentID';

    public $timestamps = false;

    protected $fillable = [
        'StudentID',
        'ClassID',
        'EnrollmentDate',
        'Status',
    ];

    protected $casts = [
        'EnrollmentDate' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'StudentID', 'StudentID');
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'ClassID', 'ClassID');
    }

    public function grade(): HasOne
    {
        return $this->hasOne(Grade::class, 'EnrollmentID', 'EnrollmentID');
    }
}