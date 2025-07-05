<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FastComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $group;
    public $test;
    public function __construct($test, $group)
    {
        $this->test = $test;
        $this->group = $group;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.fast-component');
    }
}
