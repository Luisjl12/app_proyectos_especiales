<div>
    {{-- Mensaje flash --}}
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3">
            {{ session('message') }}
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
                   placeholder="Buscar por nombre o CCT..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000] transition">
        </div>

        <button wire:click="openCreate"
                class="inline-flex items-center gap-2 bg-[#7a0000] hover:bg-[#5a0000] text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="ti ti-plus text-lg"></i> Nuevo plantel
        </button>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border-t-4 border-[#7a0000]">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">CCT</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Plantel</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nivel / Turno</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Municipio / Localidad</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($planteles as $plantel)
                    <tr wire:key="plantel-{{ $plantel->id }}" class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-600 font-mono text-sm">{{ $plantel->cct }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $plantel->nombre_escuela }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">
                            {{ $plantel->nivel_educativo ?? '—' }} / {{ $plantel->turno ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm">
                            {{ $plantel->municipio?->nombre_municipio }} / {{ $plantel->localidad?->nombre_localidad }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <button wire:click="openEdit({{ $plantel->id }})"
                                        class="p-2 rounded-lg text-gray-500 hover:text-[#7a0000] hover:bg-[#7a0000]/10 transition-colors"
                                        title="Editar">
                                    <i class="ti ti-edit text-lg"></i>
                                </button>
                                <button wire:click="delete({{ $plantel->id }})"
                                        wire:confirm="¿Eliminar este plantel? Esta acción no se puede deshacer."
                                        class="p-2 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 transition-colors"
                                        title="Eliminar">
                                    <i class="ti ti-trash text-lg"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                            No se encontraron planteles
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($planteles->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $planteles->links() }}
            </div>
        @endif
    </div>

    {{-- Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4"
             wire:click.self="$set('showModal', false)">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-lg overflow-hidden border-t-4 border-[#7a0000]">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h5 class="text-lg font-semibold text-gray-800">
                        {{ $plantelId ? '✏️ Editar plantel' : '➕ Nuevo plantel' }}
                    </h5>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                        <i class="ti ti-x text-xl"></i>
                    </button>
                </div>

                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">CCT</label>
                        <input type="text" wire:model="cct" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000]">
                        @error('cct') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la escuela</label>
                        <input type="text" wire:model="nombre_escuela" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000]">
                        @error('nombre_escuela') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nivel educativo</label>
                            <input type="text" wire:model="nivel_educativo" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Turno</label>
                            <input type="text" wire:model="turno" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sostenimiento</label>
                        <input type="text" wire:model="sostenimiento" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000]">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Municipio</label>
                            <select wire:model.live="municipio_id" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000]">
                                <option value="">Selecciona</option>
                                @foreach ($municipios as $m)
                                    <option value="{{ $m->id }}">{{ $m->nombre_municipio }}</option>
                                @endforeach
                            </select>
                            @error('municipio_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Localidad</label>
                            <select wire:model="localidades_id"
                                    {{ !$municipio_id ? 'disabled' : '' }}
                                    class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000] disabled:bg-gray-100">
                                <option value="">{{ $municipio_id ? 'Selecciona' : 'Elige municipio primero' }}</option>
                                @foreach ($localidades as $l)
                                    <option value="{{ $l->id }}">{{ $l->nombre_localidad }}</option>
                                @endforeach
                            </select>
                            @error('localidades_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">CORDE</label>
                        <select wire:model="corde_id" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7a0000]/30 focus:border-[#7a0000]">
                            <option value="">Selecciona</option>
                            @foreach ($cordes as $c)
                                <option value="{{ $c->id }}">{{ $c->clave_corde }} - {{ $c->nombre_corde }}</option>
                            @endforeach
                        </select>
                        @error('corde_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
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