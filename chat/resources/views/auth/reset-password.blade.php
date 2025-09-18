<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="row">
        <center>
            <div class="col-sm-12 col-md-4 col-lg-4"></div>
            <div class="py-5 col-sm-12 col-md-4 col-lg-4 rounded-3" style="background-color:#4bb750;">
                <img class="mx-2 mb-5" src="{{ asset('img/png.png') }}" width="35%" alt="Logo">
                <div class="row">
                    <div class="col-sm-12">
                        <span class="text-light fs-3">Reset Your Password</span>
                        <div>
                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <!-- Hidden token field -->
                                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                                <!-- Email Address -->
                                <div class="mt-4 text-light">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <br>
                                    <x-text-input id="email" class="block w-full mt-1" type="email" name="email" 
                                        :value="old('email', request()->email)" required autofocus />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- New Password -->
                                <div class="mt-4 text-light">
                                    <x-input-label for="password" :value="__('New Password')" />
                                    <br>
                                    <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="mt-4 text-light">
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <br>
                                    <x-text-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button style="background-color:#4bb750;color:white">
                                        {{ __('Reset Password') }}
                                    </x-primary-button>
                                </div>
                            </form>
                            <div class="col-sm-12 col-md-4 col-lg-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </center>
    </div>
</x-guest-layout>
