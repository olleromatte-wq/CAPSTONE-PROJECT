<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $table = 'departments';

    protected $primaryKey = 'DepartmentID';

    public $timestamps = false;

    protected $fillable = [
        'DepartmentCode',
        'DepartmentName',
    ];

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'DepartmentID', 'DepartmentID');
    }

    public function faculty(): HasMany
    {
        return $this->hasMany(Faculty::class, 'DepartmentID', 'DepartmentID');
    }
}