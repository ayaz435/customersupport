<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="row">
        <center>
            <div class="col-sm-12 col-md-4 col-lg-4"></div>
            <div class="py-5 col-sm-12 col-md-4 col-lg-4 rounded-3" style="background-color:#4bb750;">
                <img class="mx-2 mb-5" src="{{ asset('img/png.png') }}" width="35%" alt="">
                <div class="row">
                    <div class="col-sm-12">
                        <span class="text-light fs-3">Recover Your Password</span>
                        <div>
                            <div>

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <!-- Email Address -->
                                    <div class="mt-4 text-light">
                                        <x-input-label for="email" :value="__('Enter Your Registered Email')" />
                                        <br>
                                        <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- OTP -->


                                    <div class="flex items-center justify-end mt-4">
                                        <x-primary-button style="background-color:#4bb750;color:white">
                                             {{ __('Email Password Reset Link') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4"></div>
                        </div>
                    </div>
                </div>
        </center>

    </div>
</x-guest-layout>




{{--
@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-md mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold mb-6 text-center">Reset Password</h2>

    @if (session('status'))
        <div class="mb-4 text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Hidden token field -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium">New Password</label>
            <input id="password" type="password" name="password" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        <div>
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Reset Password
            </button>
        </div>
    </form>
</div>
@endsection

--}}
