<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mi App' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
</head>
<body class="bg-[#F5F0E8] min-h-screen">
    <nav class="bg-white shadow-sm border-b-4 border-[#7a0000]">
        <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo-atlas.png') }}" alt="Logo" class="h-9" onerror="this.style.display='none'">
                <span class="font-semibold text-gray-800">Proyectos Especiales</span>
            </div>
            <livewire:auth.logout />
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-10">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>