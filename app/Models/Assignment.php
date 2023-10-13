<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assignmentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function pathway()
    {
        return $this->belongsTo(Pathway::class, 'assignmentable_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'assignmentable_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
