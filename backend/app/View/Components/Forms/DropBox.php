<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class DropBox extends Component
{
  public $id;
  public $name;
  public $options;
  public $hasEmpty;
  public $selected;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($name, $options, $id = "", $hasEmpty = false, $selected="")
  {
    $this->id       = $id;
    $this->name     = $name;
    $this->options  = $options;
    $this->hasEmpty = $hasEmpty;
    $this->selected = $selected;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
      return view('components.forms.drop-box');
  }
}
