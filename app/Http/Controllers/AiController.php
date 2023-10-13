<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class AiController extends Controller
{
    public function chatgpt()
    {
        $file = public_path('gpt.log');

        $content = file_get_contents('gpt.log');

        $json = json_encode($content);

        $decode = json_decode($json);

        return json_decode(str_replace("\\\"", "\"", $decode), true);

    }
}
