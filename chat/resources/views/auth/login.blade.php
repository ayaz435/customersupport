<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
<div class="row">
   <center>
    <div class="col-sm-12 col-md-4 col-lg-4"></div>
    <div class="col-sm-12 col-md-4 col-lg-4 rounded-3  py-5" style="background-color:#4bb750;">
        <img class="mx-2 mb-5" src="{{ asset('img/png.png') }}" width="35%" alt="">
    
        <div class="row">
            <div class="col-sm-12">
                <span class="text-light fs-3">Messanger</span>
                <div>
            <div>

        <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="text-light mt-4">
            <x-input-label for="email" :value="__('Email')" /><br>
            <x-text-input id="email" class="block mt-1 w-full " type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 text-light" >
            <x-input-label for="password" :value="__('Password')" /><br>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center text-light">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>
<a href="{{ route('password.request') }}">Forgot Password</a>
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))

            @endif
<br>
            <x-primary-button class="ms-3 mt-2 " style="background-color:#4bb750;color:white">
                {{ __('Log in') }}
            </x-primary-button>
            
           <a href="{{ route('register') }}" style="background-color:#4bb750;color:white"> 
                Register
           </a>
        </div>
    </form>
</div>
    <div class="col-sm-12 col-md-4 col-lg-4"></div>
</div>
    </center>


</x-guest-layout>
