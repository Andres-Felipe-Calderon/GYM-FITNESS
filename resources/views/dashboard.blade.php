<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                <!-- Texto de bienvenida -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                        Bienvenido, {{ Auth::user()->name }}!
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <!-- Card for Ganar Masa Muscular -->
                    <a href="{{ route('routines.gainMuscle') }}" class="block rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                        <div class="h-48 bg-cover bg-center flex items-end p-4" style="background-image: url('{{ asset('images/masa muscular.jpg') }}');">
                            <div class="bg-black bg-opacity-50 w-full p-2 rounded-b-lg text-center">
                                <h3 class="text-white font-bold text-lg">Ganar Masa Muscular</h3>
                            </div>
                        </div>
                    </a>

                    <!-- Card for Perder Grasa -->
                    <a href="{{ route('routines.loseFat') }}" class="block rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                        <div class="h-48 bg-cover bg-center flex items-end p-4" style="background-image: url('{{ asset('images/perder grasa.jpg') }}');">
                            <div class="bg-black bg-opacity-50 w-full p-2 rounded-b-lg text-center">
                                <h3 class="text-white font-bold text-lg">Perder Grasa</h3>
                            </div>
                        </div>
                    </a>

                    <!-- Card for Tonificar -->
                    <a href="{{ route('routines.tone') }}" class="block rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                        <div class="h-48 bg-cover bg-center flex items-end p-4" style="background-image: url('{{ asset('images/tonifica.jpeg') }}');">
                            <div class="bg-black bg-opacity-50 w-full p-2 rounded-b-lg text-center">
                                <h3 class="text-white font-bold text-lg">Tonificar</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
