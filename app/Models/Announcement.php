<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $table = 'announcements';

    protected $primaryKey = 'AnnouncementID';

    public $timestamps = false;

    protected $fillable = [
        'AuthorID',
        'Title',
        'Content',
        'DatePosted',
        'TargetAudience',
    ];

    protected $casts = [
        'DatePosted' => 'date',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'AuthorID', 'UserID');
    }
}