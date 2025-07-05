<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HistoGramComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $test;
    public $group;
    public function __construct($test,$group)
    {
        $this->test = $test['results'];
        $this->group = $group;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.histo-gram-component',['test' => $this->test , 'group' => $this->group]);
    }
}
