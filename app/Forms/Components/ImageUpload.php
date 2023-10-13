<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;

class ImageUpload extends FileUpload
{
    protected string $view = 'forms.components.image-upload';
}
