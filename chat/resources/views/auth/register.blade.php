<x-guest-layout>


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

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <!-- Email Address -->
                                    <div class="text-light mt-4">
                                        <x-input-label for="name" :value="__('Name')" /><br>
                                        <x-text-input id="name" class="block mt-1 w-full " type="name"
                                            name="name" :value="old('name')" required autofocus
                                            autocomplete="username" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div class="text-light mt-4">
                                        <x-input-label for="email" :value="__('Email')" /><br>
                                        <x-text-input id="email" class="block mt-1 w-full " type="email"
                                            name="email" :value="old('email')" required autofocus
                                            autocomplete="username" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Password -->
                                    <div class="mt-4 text-light">
                                        <x-input-label for="password" :value="__('Password')" /><br>

                                        <x-text-input id="password" class="block mt-1 w-full" type="password"
                                            name="password" required autocomplete="new-password" />

                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                    <div class="mt-4 text-light">
                                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" /><br>

                                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password" name="password_confirmation" required
                                            autocomplete="new-password" />

                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>

                                    <!-- Remember Me -->
                                    <div class="block mt-4">
                                        <label for="remember_me" class="inline-flex items-center text-light">
                                            <input id="remember_me" type="checkbox"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                name="remember">
                                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        <x-primary-button class="ms-3 mt-2 "
                                        style="background-color:#4bb750;color:white">
                                        {{ __('Register') }}
                                    </x-primary-button>
                                    <br>
                                    <br>

                                    <a style="color: black" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        href="{{ route('login') }}">
                                        {{ __('Already registered?') }}
                                    </a>
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
