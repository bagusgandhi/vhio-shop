<?php

namespace App\Livewire;

use Livewire\Component;

class Notif extends Component
{
    public $showToast = false;
    public $message;
    public $background;

    protected $listeners = ['showToast'];

    public function showToast($value, $bg)
    {
        $this->showToast = true;
        $this->message = $value;
        $this->background = $bg;
    }

    public function render()
    {
        return view('livewire.notif');
    }
}
