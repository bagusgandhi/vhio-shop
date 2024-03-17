<?php

namespace App\Livewire;

use Livewire\Component;

class Cartupdate extends Component
{
    public $cartItem;
    public $quantity;

    protected $listeners = ['updateCart'];

    public function mount($item)
    {
        $this->cartItem = $item;
        $this->quantity = $item['quantity'];
    }

    public function increment()
    {
        $this->quantity++;
        $this->updateCart();
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->updateCart();
        }
    }

    public function updateCart()
    {
        if ($this->quantity <= 0 || $this->quantity == "") {
            \Cart::remove($this->cartItem['id']);
        } else {
            \Cart::update($this->cartItem['id'], [
                'quantity' => [
                    'relative' => false,
                    'value' => $this->quantity
                ]
            ]);
        }

        $this->dispatch('cartUpdated');
        $this->dispatch('addToCart');
    }

    public function render()
    {
        return view('livewire.cartupdate');
    }
}

