<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\HasUuid;
use App\Models\Course;

class UserCourse extends Model
{
    use HasFactory;
    use HasUuid;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
