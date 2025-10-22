<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardComponent extends Component
{
    public $title;
    public $count;
    public $desc;
    public $icon;
    public $iconColor;
    public $textColor;

    public function __construct($title, $count, $desc, $icon, $iconColor, $textColor)
    {
        $this->title = $title;
        $this->count = $count;
        $this->desc = $desc;
        $this->icon = $icon;
        $this->iconColor = $iconColor;
        $this->textColor = $textColor;
    }

    public function render()
    {
        return view('components.card-component');
    }
}
