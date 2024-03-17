<?php

namespace App\Livewire;

use Livewire\Component;

class Addtocart extends Component
{
    public $quantity;
    public $product;

    protected $listeners = ['quantityUpdated'];

    public function quantityUpdated($value)
    {
        $this->quantity = $value;
    }

    public function addToCart()
    {

        $fixprice = $this->product->price;
        $quantity = $this->quantity ?? 1;
        
        \Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'price' => floatval($fixprice),
            'quantity' => intval($quantity),
            'attributes' => [
                'image' => $this->product->image,
                'slug' => $this->product->slug,
            ]
        ]);
        
        $msg = 'Product added to cart successfully.';

        $this->dispatch('showToast', $msg, 'success');
        $this->dispatch('addToCart');
    }

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.addtocart');
    }
}
