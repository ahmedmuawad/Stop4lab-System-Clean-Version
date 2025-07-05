<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FigComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $test;
    public function __construct($test)
    {
        $this->test = $test;    
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.fig-component',['test' => $this->test]);
    }
}
