<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $ref, $size, $modal_class, $backdrop;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ref, $size = 'md', $backdrop=false)
    {
        $this->ref = $ref;
        $this->size = $size;
        $this->backdrop = $backdrop;
    }

    public function setModalClass($size)
    {
        $class;
        
        switch ($size) {
            case 'lg':
                $class = 'sm:max-w-4xl';
                break;

            case 'sm':
                $class = 'sm:max-w-lg';
                break;
            
            default:
                $class = 'sm:max-w-xl';
                break;
        }

        $this->modal_class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
