@extends('layouts.base-layout')

@section('title', 'Vhio Shop Products')
@section('content')
    <div class="container mx-auto">
        @include('components.header')
        @if (session()->has('error'))
            @include('components.error-message', ['message' => session('error')])
        @else
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-8 items-center px-8">
                @foreach ($allProduct as $index => $product)
                    @include('components.product-card', [
                        'product' => $product,
                        'index' => $index,
                    ])
                @endforeach
            </div>
        @endif
    </div>
@endsection
