<?php

namespace App\View\Components;

use Illuminate\View\Component;

class semenImagesComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $group = [];

    public function __construct($group)
    {
        $this->group = $group;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.semen-images-component');
    }
}
