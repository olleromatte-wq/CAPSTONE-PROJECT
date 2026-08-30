<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $primaryKey = 'SubjectCode';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'SubjectCode',
        'SubjectName',
        'Units',
        'PrerequisiteSubject',
    ];

    protected $casts = [
        'Units' => 'integer',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'SubjectCode', 'SubjectCode');
    }

    public function prerequisite(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'PrerequisiteSubject', 'SubjectCode');
    }
}