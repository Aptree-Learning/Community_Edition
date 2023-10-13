<?php

namespace App\Models;

use App\Enums\FormType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settings extends Model
{
    use HasFactory;

    protected $casts = [
        'form_type' => FormType::class,
    ];

    protected $table = 'settings';

    protected $guarded = [];
}
