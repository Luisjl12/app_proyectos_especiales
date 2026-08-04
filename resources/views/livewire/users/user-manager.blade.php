<div>
    {{-- Mensaje flash --}}
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3 flex items-center justify-between">
            <span>✅ {{ session('message') }}</span>
        </div>
    @endif

    {{-- Barra superior: buscador + botón nuevo --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div class="relative w-full sm:w-80">
            <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text"
                wire:model.live.debounce.300ms="search"
                name="buscar_usuario_no_autofill"
                id="buscar-usuario-{{ uniqid() }}"
                autocomplete="off"
                role="presentation"
                data-lpignore="true"
                data-1p-ignore
                placeholder="Buscar usuario..."
                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000] transition">
        </div>

        <button wire:click="openCreate"
                class="inline-flex items-center gap-2 bg-[#7a0000] hover:bg-[#5a0000] text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="ti ti-plus text-lg"></i> Nuevo usuario
        </button>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border-t-4 border-[#7a0000]">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombre</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Correo</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $user)
                    <tr wire:key="user-{{ $user->id }}" class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-[#7a0000]/10 flex items-center justify-center text-[#7a0000] font-semibold text-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <button wire:click="openEdit({{ $user->id }})"
                                        class="p-2 rounded-lg text-gray-500 hover:text-[#7a0000] hover:bg-[#7a0000]/10 transition-colors"
                                        title="Editar">
                                    <i class="ti ti-edit text-lg"></i>
                                </button>
                                <button wire:click="delete({{ $user->id }})"
                                        wire:confirm="¿Eliminar este usuario? Esta acción no se puede deshacer."
                                        class="p-2 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 transition-colors"
                                        title="Eliminar">
                                    <i class="ti ti-trash text-lg"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-gray-400">
                            No se encontraron usuarios
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4"
             wire:click.self="$set('showModal', false)">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md overflow-hidden border-t-4 border-[#7a0000]">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h5 class="text-lg font-semibold text-gray-800">
                        {{ $userId ? '✏️ Editar usuario' : '➕ Nuevo usuario' }}
                    </h5>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                        <i class="ti ti-x text-xl"></i>
                    </button>
                </div>

                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" wire:model="name"
                               class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000]">
                        @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
                        <input type="email" wire:model="email"
                               class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000]">
                        @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Contraseña
                            @if ($userId)
                                <span class="text-gray-400 font-normal">(dejar en blanco para no cambiar)</span>
                            @endif
                        </label>
                        <input type="password" wire:model="password"
                               class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000]">
                        @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <button wire:click="$set('showModal', false)"
                            class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 font-medium transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="save"
                            class="inline-flex items-center gap-2 bg-[#7a0000] hover:bg-[#5a0000] text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-colors">
                        <i class="ti ti-device-floppy"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>