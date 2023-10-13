<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalXl extends Component
{
    public $ref, $backdrop;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ref, $backdrop=false)
    {
        $this->ref = $ref;
        $this->backdrop = $backdrop;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-xl');
    }
}
