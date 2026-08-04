<x-layouts.app title="Dashboard">
    <div class="bg-white rounded-xl shadow-md overflow-hidden border-t-4 border-[#7a0000]">
        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                ¡Bienvenido, <span class="text-[#7a0000]">{{ auth()->user()->name ?? 'Usuario' }}</span>!
            </h2>
            <p class="text-gray-500">Has iniciado sesión correctamente en el sistema.</p>
        </div>
    </div>

    <!--Usuarios-->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('usuarios.index') }}"
           class="bg-white rounded-xl shadow-md border-t-4 border-[#7a0000] p-6 flex items-center gap-4 hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 rounded-full bg-[#7a0000]/10 flex items-center justify-center">
                <i class="ti ti-users text-2xl text-[#7a0000]"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Gestor de usuarios</h3>
                <p class="text-sm text-gray-500">Crear, editar y eliminar usuarios</p>
            </div>
        </a>
    </div>

    <!--Planteles-->
    <a href="{{ route('planteles.index') }}"
    class="bg-white rounded-xl shadow-md border-t-4 border-[#7a0000] p-6 flex items-center gap-4 hover:shadow-lg transition-shadow">
        <div class="w-12 h-12 rounded-full bg-[#7a0000]/10 flex items-center justify-center">
            <i class="ti ti-building text-2xl text-[#7a0000]"></i>
        </div>
        <div>
            <h3 class="font-semibold text-gray-800">Gestión de planteles</h3>
            <p class="text-sm text-gray-500">Administrar escuelas y su información</p>
        </div>
    </a>
</x-layouts.app>