<?php

namespace App\Http\Traits;
use Str;

trait HasUuid{

    public static function boot()
    {
        parent::boot();
        
        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}