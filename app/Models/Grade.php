<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $table = 'grades';

    protected $primaryKey = 'GradeID';

    public $timestamps = false;

    protected $fillable = [
        'EnrollmentID',
        'PrelimGrade',
        'MidtermGrade',
        'FinalGrade',
        'Remarks',
    ];

    protected $casts = [
        'PrelimGrade' => 'float',
        'MidtermGrade' => 'float',
        'FinalGrade' => 'float',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class, 'EnrollmentID', 'EnrollmentID');
    }
}