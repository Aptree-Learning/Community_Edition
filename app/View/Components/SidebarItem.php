<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarItem extends Component
{
    public $label, $link, $active;
    /**
     * Create a new component instance.
     */
    public function __construct($label, $link, $active = false)
    {
        $this->label = $label;
        $this->link = $link;
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar-item');
    }
}
