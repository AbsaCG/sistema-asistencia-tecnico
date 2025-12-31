<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title inertia>{{ config('app.name', 'Control de Asistencia') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @inertiaHead
  </head>
  <body class="bg-gray-50 overflow-x-hidden">
    @inertia
  </body>
</html>
