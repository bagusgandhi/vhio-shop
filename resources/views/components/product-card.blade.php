<div class="card w-full bg-base-100 shadow-xl">
    <figure><img src="{{ url($product->image) }}"" alt="{{ $product->name }}" /></figure>
    <div class="card-body">
        <h2 class="card-title text-sm justify-center">{{ $product->name }}</h2>
        <p class="text-sm text-center ">{{ \App\Helpers\CurrencyFormat::data($product->price) }}</p>
        <div class="card-actions justify-center">
            <livewire:addtocart key="{{ $product->id }}" :product="$product" />
        </div>
    </div>
</div>
