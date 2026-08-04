<x-layouts.app title="Dashboard">
    {{-- Encabezado de bienvenida --}}
    <div class="mb-8">
        <p class="text-sm text-gray-500 mb-1">{{ now()->translatedFormat('l, d \d\e F \d\e Y') }}</p>
        <h1 class="text-3xl font-semibold text-gray-900" style="font-family: 'Source Serif 4', Georgia, serif;">
            Bienvenido, <span class="text-[#7a0000]">{{ auth()->user()->name ?? 'Usuario' }}</span>
        </h1>
        <p class="text-gray-500 mt-1">Panel de control de plataforma de proyectos especiales.</p>
    </div>

    {{-- Accesos --}}
    <div>
        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Accesos</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('usuarios.index') }}"
               class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md hover:border-[#7a0000]/20 transition-all relative overflow-hidden">
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#7a0000] to-[#691C32]"></div>
                <div class="w-12 h-12 shrink-0 rounded-full bg-[#7a0000]/10 flex items-center justify-center">
                    <i class="ti ti-users text-2xl text-[#7a0000]"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-800">Gestor de usuarios</h3>
                    <p class="text-sm text-gray-500">Crear, editar y eliminar usuarios</p>
                </div>
                <i class="ti ti-chevron-right text-gray-300 group-hover:text-[#7a0000] group-hover:translate-x-1 transition-all"></i>
            </a>

            <a href="{{ route('planteles.index') }}"
               class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md hover:border-[#7a0000]/20 transition-all relative overflow-hidden">
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#7a0000] to-[#691C32]"></div>
                <div class="w-12 h-12 shrink-0 rounded-full bg-[#7a0000]/10 flex items-center justify-center">
                    <i class="ti ti-building text-2xl text-[#7a0000]"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-800">Gestión de planteles</h3>
                    <p class="text-sm text-gray-500">Administrar escuelas y su información</p>
                </div>
                <i class="ti ti-chevron-right text-gray-300 group-hover:text-[#7a0000] group-hover:translate-x-1 transition-all"></i>
            </a>
        </div>
    </div>
</x-layouts.app>