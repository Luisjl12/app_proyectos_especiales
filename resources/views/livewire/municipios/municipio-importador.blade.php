<div>
    <div class="mb-6">
        <a href="{{ route('municipios.index') }}" class="text-sm text-gray-500 hover:text-[#7a0000] inline-flex items-center gap-1">
            <i class="ti ti-arrow-left"></i> Volver a municipios
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border-t-4 border-[#7a0000] max-w-2xl">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Importar municipios</h2>
            <p class="text-sm text-gray-500 mt-1">
                Sube un archivo <strong>.xlsx</strong> o <strong>.csv</strong> con una columna llamada
                <code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs">nombre_municipio</code> en la primera fila.
            </p>
        </div>

        <div class="px-6 py-5 space-y-4">
            <div>
                <label class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 rounded-lg py-10 cursor-pointer hover:border-[#7a0000]/40 hover:bg-[#7a0000]/5 transition-colors">
                    <i class="ti ti-file-upload text-3xl text-gray-400"></i>
                    <span class="text-sm text-gray-600">
                        {{ $archivo ? $archivo->getClientOriginalName() : 'Haz clic para seleccionar un archivo' }}
                    </span>
                    <span class="text-xs text-gray-400">XLSX, XLS o CSV — máx. 5 MB</span>
                    <input type="file" wire:model="archivo" accept=".xlsx,.xls,.csv" class="hidden">
                </label>
                @error('archivo') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            @if ($archivo && !$resultado)
                <button wire:click="importar" wire:loading.attr="disabled" wire:target="importar"
                        class="inline-flex items-center gap-2 bg-[#7a0000] hover:bg-[#5a0000] text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="importar">
                        <i class="ti ti-upload"></i> Importar
                    </span>
                    <span wire:loading wire:target="importar">Procesando...</span>
                </button>
            @endif

            @if ($resultado)
                <div class="rounded-lg border border-gray-100 divide-y divide-gray-100">
                    <div class="px-4 py-3 flex items-center justify-between">
                        <span class="text-sm text-gray-600">Municipios creados</span>
                        <span class="font-semibold text-green-700">{{ $resultado['creados'] }}</span>
                    </div>
                    <div class="px-4 py-3 flex items-center justify-between">
                        <span class="text-sm text-gray-600">Duplicados omitidos</span>
                        <span class="font-semibold text-amber-700">{{ $resultado['duplicados'] }}</span>
                    </div>
                    <div class="px-4 py-3 flex items-center justify-between">
                        <span class="text-sm text-gray-600">Filas con error</span>
                        <span class="font-semibold text-red-700">{{ $resultado['errores'] }}</span>
                    </div>
                </div>

                @if (count($resultado['mensajesError']) > 0)
                    <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3">
                        <p class="text-sm font-medium text-red-800 mb-1">Detalle de errores:</p>
                        <ul class="text-sm text-red-700 list-disc list-inside space-y-0.5">
                            @foreach ($resultado['mensajesError'] as $mensaje)
                                <li>{{ $mensaje }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button wire:click="$set('resultado', null)" class="text-sm text-[#7a0000] hover:underline">
                    Importar otro archivo
                </button>
            @endif
        </div>
    </div>
</div>
