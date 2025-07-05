<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SettingComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $test;
    public $settings;
    public function __construct($test,$settings)
    {
        $this->test = $test;
        $this->settings = $settings;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.setting-component',['settings' => $this->settings ,'test' => $this->test ]);
    }
}
