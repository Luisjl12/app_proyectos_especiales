<div class="relative min-h-screen flex items-center justify-center px-4 bg-cover bg-center"
     style="background-image: url('{{ asset('img/fondo_proyectos.png') }}');">

    <!-- Overlay vino encima de la imagen -->
    <div class="absolute inset-0 bg-[#A12910] opacity-70"></div>

    <!-- Contenido del login -->
    <div class="relative w-full max-w-md bg-white rounded-xl shadow-xl overflow-hidden border-t-4 border-[#7a0000]">
        
        <div class="px-8 pt-8 pb-4 text-center">
            <img src="{{ asset('') }}" alt="Logo" class="h-14 mx-auto mb-4" onerror="this.style.display='none'">
            <h1 class="text-xl font-semibold text-gray-800">Iniciar sesión</h1>
            <p class="text-sm text-gray-500 mt-1">Ingresa tus credenciales para continuar</p>
        </div>

        <form wire:submit="login" class="px-8 pb-8 space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                <input type="email" wire:model="email"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800
                              focus:outline-none focus:ring-2 focus:ring-[#7a0000] focus:border-[#7a0000] transition"
                       placeholder="Escribe tu correo electrónico...">
                @error('email')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" wire:model="password"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800
                              focus:outline-none focus:ring-2 focus:ring-[#7a0000] focus:border-[#7a0000] transition"
                       placeholder="••••••••">
                @error('password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-[#7a0000] hover:bg-[#691C32] text-white font-medium
                           rounded-lg py-2.5 text-sm transition-colors duration-200
                           flex items-center justify-center gap-2 cursor-pointer">
                <span wire:loading.remove wire:target="login">Entrar</span>
                <span wire:loading wire:target="login">Verificando...</span>
            </button>
        </form>
    </div>
</div>
