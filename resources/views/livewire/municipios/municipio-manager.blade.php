<div>
    {{-- Mensajes flash --}}
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3">
             {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Barra superior --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div class="relative w-full sm:w-80">
            <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text"
                   wire:model.live.debounce.300ms="search"
                   autocomplete="off"
                   readonly
                   onfocus="this.removeAttribute('readonly');"
                   placeholder="Buscar municipio..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000] transition">
        </div>

        <div class="flex gap-2">
            <a href="{{ route('municipios.importar') }}"
            class="inline-flex items-center gap-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium px-4 py-2.5 rounded-lg transition-colors">
                <i class="ti ti-file-upload text-lg"></i> Importar
            </a>
            <button wire:click="openCreate"
                    class="inline-flex items-center gap-2 bg-[#7a0000] hover:bg-[#5a0000] text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
                <i class="ti ti-plus text-lg"></i> Nuevo municipio
            </button>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border-t-4 border-[#7a0000]">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Municipio</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Localidades</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($municipios as $municipio)
                    <tr wire:key="municipio-{{ $municipio->id }}" class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $municipio->nombre_municipio }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                {{ $municipio->localidades_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <button wire:click="openEdit({{ $municipio->id }})"
                                        class="p-2 rounded-lg text-gray-500 hover:text-[#7a0000] hover:bg-[#7a0000]/10 transition-colors"
                                        title="Editar">
                                    <i class="ti ti-edit text-lg"></i>
                                </button>
                                <button wire:click="delete({{ $municipio->id }})"
                                        wire:confirm="¿Eliminar este municipio? Esta acción no se puede deshacer."
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
                            No se encontraron municipios
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($municipios->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $municipios->links() }}
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
                        {{ $municipioId ? 'Editar municipio' : 'Nuevo municipio' }}
                    </h5>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                        <i class="ti ti-x text-xl"></i>
                    </button>
                </div>

                <div class="px-6 py-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del municipio</label>
                    <input type="text" wire:model="nombre_municipio"
                           class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000]">
                    @error('nombre_municipio') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 font-medium transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="save" class="inline-flex items-center gap-2 bg-[#7a0000] hover:bg-[#5a0000] text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-colors">
                        <i class="ti ti-device-floppy"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
