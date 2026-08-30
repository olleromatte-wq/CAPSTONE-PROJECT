<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    protected $table = 'programs';

    protected $primaryKey = 'ProgramID';

    public $timestamps = false;

    protected $fillable = [
        'DepartmentID',
        'ProgramCode',
        'ProgramName',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'DepartmentID', 'DepartmentID');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'ProgramID', 'ProgramID');
    }
}