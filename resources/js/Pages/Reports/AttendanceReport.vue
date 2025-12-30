<template>
  <AppLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Reportes de Asistencia</h1>
        <p class="mt-2 text-gray-600">Consulta y descarga reportes de asistencia</p>
      </div>

      <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div class="bg-white shadow rounded-lg p-6 cursor-pointer hover:shadow-lg transition">
          <p class="text-5xl mb-3">📄</p>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Reporte por Estudiante</h3>
          <p class="text-sm text-gray-600">Ver historial de asistencia de un estudiante</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 cursor-pointer hover:shadow-lg transition">
          <p class="text-5xl mb-3">📊</p>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Reporte por Grado</h3>
          <p class="text-sm text-gray-600">Estadísticas de asistencia por grado</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 cursor-pointer hover:shadow-lg transition">
          <p class="text-5xl mb-3">📈</p>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Reporte Mensual</h3>
          <p class="text-sm text-gray-600">Análisis detallado del mes seleccionado</p>
        </div>
      </div>

      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Filtros de Búsqueda</h3>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Período</label>
            <select class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
              <option>Este mes</option>
              <option>Último mes</option>
              <option>Último trimestre</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Grado</label>
            <select class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
              <option>Todos</option>
              <option>1ro</option>
              <option>2do</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Formato</label>
            <select class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
              <option>PDF</option>
              <option>Excel</option>
              <option>CSV</option>
            </select>
          </div>
          <div class="flex items-end">
            <button class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
              Descargar
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>
