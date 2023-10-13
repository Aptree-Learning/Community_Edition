<?php

namespace App\Models;

use App\Models\Course;
use App\Http\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;
    use HasUuid;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function items()
    {
        return $this->belongsToMany(ModuleItem::class, 'enrollment_module_items');
    }

    public function enrollmentModuleItems()
    {
        return $this->hasMany(EnrollmentModuleItem::class);
    }

    public function enrollmentModules()
    {
        return $this->hasMany(EnrollmentModule::class);
    }

    public function isComplete()
    {
        return $this->completed_at ? true : false;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
