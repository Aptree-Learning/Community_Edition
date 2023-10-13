<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function randomAnswers()
    {
        return $this->hasMany(Answer::class)->inRandomOrder();
    }

    public function getAnswerArray()
    {
        $array = [];
        foreach($this->answers as $answer)
        {
            $array[$answer->answer] = $answer->is_correct ? true : false;
        }

        return $array;
    }
}
