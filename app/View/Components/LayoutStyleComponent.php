<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LayoutStyleComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $reports_settings;
    public $group;

    public $header;

    public function __construct($settings,$group,$header)
    {
        $this->reports_settings = $settings;
        $this->group = $group;
        $this->header = $header;
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.layout-style-component',['group'=>$this->group , 'reports_settings' =>$this->reports_settings, 'header' => $this->header]);
    }
}
