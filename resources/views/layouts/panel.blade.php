<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div id="loader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.6); z-index: 9999; display: flex; align-items: center; justify-content: center;">
        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-blue-500 border-opacity-75"></div>
    </div>

    {{ $slot }}

    @filamentScripts
    <script>
        document.addEventListener('livewire:load', () => {
            Livewire.hook('message.sent', () => {
                document.getElementById('loader').style.display = 'flex';
            });

            Livewire.hook('message.processed', () => {
                document.getElementById('loader').style.display = 'none';
            });
        });
    </script>
</body>
</html>
