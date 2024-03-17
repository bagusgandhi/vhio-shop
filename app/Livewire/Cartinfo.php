<?php

namespace App\Livewire;

use Livewire\Component;

class Cartinfo extends Component
{
    public $totalItems = 0;
    public $subTotal = 0;
    protected $listeners = ['addToCart' => 'refresh'];

    public function refresh(){
        $this->totalItems = \Cart::getTotalQuantity();
        $this->subTotal = \Cart::getTotal();
    }

    public function mount()
    {
        $this->totalItems = \Cart::getTotalQuantity();
        $this->subTotal = \Cart::getTotal();
    }
    
    public function render()
    {
        return view('livewire.cartinfo');
    }
}
