<x-guest-layout>
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registro - Universidad de Córdoba</title>
        <meta name="description" content="Formulario de registro - Universidad de Córdoba">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="antialiased text-gray-800"
        style="background-image: url('{{ asset('img/fondo_unicor.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

        <!-- ====== FORMULARIO DE REGISTRO ====== -->
        <div class="min-h-screen flex flex-col justify-center items-center bg-black/40">
            <!-- Logo clicable -->
            

            <div class="flex justify-center mb-4 -mt-6">
                <i class="fa fa-user-lock text-4xl text-gray-800"></i>
            </div>


            
            <!-- FORMULARIO DE REGISTRO -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">

                <!-- LOGO DENTRO DEL CUADRO -->
                <a href="{{ url('/') }}" class="mb-4">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('img/logo.jpeg') }}" alt="Universidad de Córdoba" class="h-20 w-auto">
                </div>
            </a>

                <!-- TÍTULO -->
                <h2 class="text-center text-xl font-semibold text-gray-800 mb-4">Crear cuenta</h2>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nombre -->
                    <div>
                        <x-label for="name" value="Nombre" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                            required autofocus />
                    </div>

                    <!-- Correo -->
                    <div class="mt-4">
                        <x-label for="email" value="Correo electrónico" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                            required />
                    </div>

                    <!-- Contraseña -->
                    <div class="mt-4">
                        <x-label for="password" value="Contraseña" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />
                    </div>

                    <!-- Confirmar contraseña -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" value="Confirmar contraseña" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required />
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center justify-between mt-6">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            ¿Ya tienes una cuenta?
                        </a>

                        <x-button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded">
                            REGISTRARSE
                        </x-button>
                    </div>
                </form>
            </div>

        </div>

        <!-- ====== FOOTER ====== -->
        <footer class="bg-white/90 border-t py-4 text-center text-sm text-gray-600">
            &copy; {{ date('Y') }} Universidad de Córdoba — Proyecto de mapa interactivo
        </footer>

    </body>

    </html>
</x-guest-layout>