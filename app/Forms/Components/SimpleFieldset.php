<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Component;

class SimpleFieldset extends Component
{
    protected string $view = 'forms.components.simple-fieldset';

    public static function make(): static
    {
        return new static();
    }
}
