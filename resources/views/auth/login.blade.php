<x-guest-layout>
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Acceder - Universidad de Córdoba</title>
        <meta name="description" content="Proyecto mapa interactivo - Universidad de Córdoba">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="antialiased">

        <!-- Fondo a pantalla completa -->
        <div class="relative min-h-screen flex items-center justify-center bg-cover bg-center"
            style="background-image: url('{{ asset('img/fondo_unicor.jpg') }}');">

            <!-- Capa oscura -->
            <div class="absolute inset-0 bg-black opacity-40"></div>

            <!-- Contenedor del formulario -->
            <div class="relative bg-white rounded-lg shadow-lg p-8 w-full max-w-md z-10">

                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('img/logo.jpeg') }}" alt="Logo Universidad de Córdoba"
                            class="h-16 hover:scale-105 transition-transform">
                    </a>

                </div>

                <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">Acceder</h2>

                <!-- Validaciones -->
                <x-validation-errors class="mb-4" />
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Formulario -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Correo -->
                    <div class="mb-4">
                        <x-label for="email" value="Correo electrónico" />
                        <x-input id="email" class="block mt-1 w-full border-gray-300 rounded-lg" type="email"
                            name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-4">
                        <x-label for="password" value="Contraseña" />
                        <x-input id="password" class="block mt-1 w-full border-gray-300 rounded-lg" type="password"
                            name="password" required autocomplete="current-password" />
                    </div>

                    <!-- Recordarme -->
                    <div class="flex items-center justify-between mb-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-800">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <!-- Botón -->
                    <div class="flex items-center justify-between gap-3 mt-4">
                        <!-- Botón Iniciar Sesión -->
                        <x-button
                            class="w-1/2 text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-1 rounded-lg">
                            Iniciar sesión
                        </x-button>

                        <!-- Botón Registrarse -->
                        <a href="{{ route('register') }}"
                            class="w-1/2 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-1.5 rounded-lg transition">
                            Registrarse
                        </a>
                    </div>

                </form>

                <!-- Pie -->
                <p class="text-center text-gray-500 text-xs mt-6">
                    Centro de Innovación en TIC - CINTIA<br>
                    Universidad de Córdoba • Montería, Colombia
                </p>
            </div>
        </div>
    </body>

    </html>
</x-guest-layout>