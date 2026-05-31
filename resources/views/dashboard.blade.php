<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Panel Principal') }}
            </h2>

            <div class="flex gap-6">
    <a href="{{ route('motos') }}" class="text-blue hover:text-gray-200 font-medium">Motos</a>
    <a href="{{ route('carros') }}" class="text-blue hover:text-gray-200 font-medium">Carros</a>
</div>

        </div>
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-red-600">
        <div class="text-center text-white">
            <h1 class="text-4xl font-bold mb-4">🚗 Bienvenido al panel de vehículos</h1>
            <p class="text-lg">Aquí podrás administrar la información de carros y motos fácilmente.</p>
            <a href="{{ route('motos') }}" class="text-blue hover:text-gray-200 font-medium">Motos</a> 
        </div>
    </div>
</x-app-layout>
