@extends('layouts.base-layout')

@section('title', 'Your Cart')
@section('content')
    <div class="container mx-auto">
        @include('components.header')
        @if (session()->has('error'))
            @include('components.error-message', ['message' => session('error')])
        @else
            <livewire:cartlist />
        @endif
    </div>
@endsection
