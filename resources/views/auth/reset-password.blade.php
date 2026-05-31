<x-guest-layout>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablecer contraseña - Universidad de Córdoba</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-cover bg-center" 
      style="background-image: url('{{ asset('img/fondo_unicor.jpg') }}'); background-attachment: fixed;">

    <!-- Fondo semitransparente -->
    <div class="min-h-screen flex flex-col items-center justify-center bg-black/40 backdrop-blur-sm">

        <!-- CONTENEDOR DEL FORMULARIO -->
        <div class="w-full sm:max-w-md bg-white/100 shadow-lg rounded-xl px-8 py-10">

            <!-- LOGO DENTRO DEL CUADRO -->
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/logo.jpeg') }}" 
                     alt="Logo Universidad de Córdoba" 
                     class="h-20 w-auto mx-auto mb-4">
            </a>

            <!-- Título -->
            <h2 class="text-center text-xl font-semibold text-gray-800 mb-4">Restablecer contraseña</h2>

            <!-- Texto informativo -->
            <div class="mb-4 text-sm text-gray-600 text-center leading-relaxed">
                ¿Olvidaste tu contraseña? No hay problema.  
                Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.
            </div>

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    {{ $value }}
                </div>
            @endsession

            <x-validation-errors class="mb-4" />

            <!-- Formulario -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div>
                    <x-label for="email" value="Correo electrónico" class="text-gray-800" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                             :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div class="flex items-center justify-center mt-6">
                    <x-button class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-md">
                        ENVIAR ENLACE
                    </x-button>
                </div>
            </form>

            <!-- Enlace al login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-green-700 hover:underline">
                    ← Volver al inicio de sesión
                </a>
            </div>
        </div>
    </div>
</body>
</html>
</x-guest-layout>