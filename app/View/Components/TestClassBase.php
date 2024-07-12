<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class TestClassBase extends Component
{
    public $classBaseMessage;
    public $defaultMessage;
    /**
     * Create a new component instance.
     */
    public function __construct($classBaseMessage,$defaultMessage="初期値です")
    {
        $this->classBaseMessage = $classBaseMessage;
        $this->defaultMessage = $defaultMessage;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tests.test-class-base-component');
    }
}
