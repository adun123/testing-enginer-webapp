<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Accounting App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-screen bg-gray-100 flex">

    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="images/bg-login.jpg" 
             class="w-full h-full object-cover" alt="Background">
        <div class="absolute inset-0 bg-black/30"></div> <!-- Overlay -->
    </div>

    <!-- Content -->
    <div class="relative flex w-full h-full">
        <!-- Left Side -->
        <div class="hidden lg:flex flex-col justify-center items-start text-white px-16 w-1/2">
            <h1 class="text-4xl font-bold mb-4 drop-shadow-lg">Accounting App</h1>
            <p class="text-lg opacity-90">“Daftar sekarang dan kelola keuangan bisnis Anda dengan mudah.”</p>
        </div>

        <!-- Right Side (Register Form) -->
        <div class="flex w-full lg:w-1/2 justify-center items-center p-6">
            <div class="w-full max-w-md bg-white/30 backdrop-blur-md rounded-2xl shadow-lg p-8">
                
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Register</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-white"/>
                        <x-text-input id="name" class="block mt-1 w-full"
                                      type="text" name="name" :value="old('name')" required autofocus autocomplete="name"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-200"/>
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" class="text-white"/>
                        <x-text-input id="email" class="block mt-1 w-full"
                                      type="email" name="email" :value="old('email')" required autocomplete="username"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-200"/>
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" class="text-white"/>
                        <x-text-input id="password" class="block mt-1 w-full"
                                      type="password" name="password" required autocomplete="new-password"/>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-200"/>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white"/>
                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                      type="password" name="password_confirmation" required autocomplete="new-password"/>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-200"/>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-6">
                        <a class="underline text-sm text-gray-200 hover:text-white"
                           href="{{ route('login') }}">
                            Already registered?
                        </a>

                        <x-primary-button class="ms-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
