<?php

namespace App\Models;

use App\Http\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EnrollmentModule extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = [];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function items()
    {
        return $this->hasMany(EnrollmentModuleItem::class);
    }
}
