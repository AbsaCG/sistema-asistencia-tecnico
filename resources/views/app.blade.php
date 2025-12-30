<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title inertia>{{ config('app.name', 'Control de Asistencia') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @inertiaHead
  </head>
  <body class="bg-gray-50">
    @inertia
  </body>
</html>
