@extends('layouts.base-layout')

@section('title', 'Login to Vhio Shop')
@section('content')
    <div class="container mx-auto py-14 flex items-center justify-center h-screen">
        <div class="flex flex-col gap-4 mx-auto w-1/3">
            <form action="{{ route('authenticate') }}" class="flex flex-col space-y-6 pb-6" method="POST">
                @csrf
                <h1 class="text-2xl font-bold text-center text-purple-900">Vhio Shop</h1>
                @include('components.input', [
                    'label' => 'Email',
                    'name' => 'email',
                    'place_holder' => 'Masukan Email',
                ])
                @error('email')
                    @include('components.error-message', ['message' => $message])
                @enderror
                @include('components.input', [
                    'label' => 'Password',
                    'name' => 'password',
                    'type' => 'password',
                    'place_holder' => 'Masukan Password',
                ])
                @error('password')
                    @include('components.error-message', ['password' => $message])
                @enderror
                <button type="submit" class="btn btn-primary">Log In</button>
            </form>
        </div>
    </div>
@endsection
