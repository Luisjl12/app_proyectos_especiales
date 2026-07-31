<x-layouts.app title="Dashboard">
    <div class="min-h-screen bg-[#F5F0E8]">

        {{-- Barra de navegación superior --}}
        <nav class="bg-white shadow-sm border-b-4 border-[#7a0000]">
            <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/logo-atlas.png') }}" alt="Logo" class="h-9" onerror="this.style.display='none'">
                    <span class="font-semibold text-gray-800">Panel de control</span>
                </div>
                <livewire:auth.logout />
            </div>
        </nav>

        {{-- Contenido --}}
        <div class="max-w-5xl mx-auto px-6 py-10">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border-t-4 border-[#7a0000]">
                <div class="p-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                        👋 ¡Bienvenido, <span class="text-[#7a0000]">{{ auth()->user()->name ?? 'Usuario' }}</span>!
                    </h2>
                    <p class="text-gray-500">
                        Has iniciado sesión correctamente en el sistema.
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>