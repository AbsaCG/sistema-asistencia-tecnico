<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div>
        <h1 class="text-3xl font-bold text-gray-900">📊 Reportes de Asistencia</h1>
        <p class="mt-2 text-gray-600">Filtra, visualiza y descarga reportes personalizados</p>
      </div>

      <!-- Filtros -->
      <div class="bg-white shadow rounded-lg p-6 no-print">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">🔍 Filtros de Búsqueda</h2>
        
        <form @submit.prevent="applyFilters" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <!-- Fecha Inicio -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📅 Fecha Inicio</label>
            <input
              v-model="filters.start_date"
              type="date"
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>

          <!-- Fecha Fin -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📅 Fecha Fin</label>
            <input
              v-model="filters.end_date"
              type="date"
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>

          <!-- Carrera -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">🎓 Carrera Técnica</label>
            <select
              v-model="filters.career_id"
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Todas las Carreras</option>
              <option v-for="career in careers" :key="career.id" :value="career.id">
                {{ career.name }}
              </option>
            </select>
          </div>

          <!-- Estado -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">✅ Estado</label>
            <select
              v-model="filters.status"
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Todos los Estados</option>
              <option value="present">Presente</option>
              <option value="late">Tarde</option>
              <option value="absent">Ausente</option>
              <option value="justified">Justificado</option>
            </select>
          </div>

          <!-- Estudiante -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">👨‍🎓 Estudiante</label>
            <select
              v-model="filters.student_id"
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Todos los Estudiantes</option>
              <option v-for="student in students" :key="student.id" :value="student.id">
                {{ student.name }} ({{ student.dni }})
              </option>
            </select>
          </div>

          <!-- Botones -->
          <div class="flex items-end space-x-2">
            <button
              type="submit"
              class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition"
            >
              🔍 Filtrar
            </button>
            <button
              type="button"
              @click="clearFilters"
              class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition"
            >
              🔄 Limpiar
            </button>
          </div>
        </form>
      </div>

      <!-- Estadísticas Generales -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-5">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
          <p class="text-sm text-blue-700 font-medium">📊 Total Registros</p>
          <p class="text-3xl font-bold text-blue-900 mt-1">{{ stats.total }}</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
          <p class="text-sm text-green-700 font-medium">✅ Presente</p>
          <p class="text-3xl font-bold text-green-900 mt-1">{{ stats.present }}</p>
          <p class="text-xs text-green-600 mt-1">{{ getPercentage(stats.present, stats.total) }}%</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
          <p class="text-sm text-yellow-700 font-medium">⏰ Tarde</p>
          <p class="text-3xl font-bold text-yellow-900 mt-1">{{ stats.late }}</p>
          <p class="text-xs text-yellow-600 mt-1">{{ getPercentage(stats.late, stats.total) }}%</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
          <p class="text-sm text-red-700 font-medium">❌ Ausente</p>
          <p class="text-3xl font-bold text-red-900 mt-1">{{ stats.absent }}</p>
          <p class="text-xs text-red-600 mt-1">{{ getPercentage(stats.absent, stats.total) }}%</p>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
          <p class="text-sm text-purple-700 font-medium">📝 Justificado</p>
          <p class="text-3xl font-bold text-purple-900 mt-1">{{ stats.justified }}</p>
          <p class="text-xs text-purple-600 mt-1">{{ getPercentage(stats.justified, stats.total) }}%</p>
        </div>
      </div>

      <!-- Estadísticas por Carrera -->
      <div v-if="careerStats.length > 0" class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">📊 Estadísticas por Carrera</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div v-for="career in careerStats" :key="career.career" class="border border-gray-200 rounded-lg p-4">
            <h3 class="font-semibold text-gray-900 mb-2">{{ career.career }}</h3>
            <div class="space-y-1 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-600">Total:</span>
                <span class="font-semibold">{{ career.total }}</span>
              </div>
              <div class="flex justify-between text-green-600">
                <span>Presente:</span>
                <span class="font-semibold">{{ career.present }}</span>
              </div>
              <div class="flex justify-between text-yellow-600">
                <span>Tarde:</span>
                <span class="font-semibold">{{ career.late }}</span>
              </div>
              <div class="flex justify-between text-red-600">
                <span>Ausente:</span>
                <span class="font-semibold">{{ career.absent }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Botones de Descarga -->
      <div class="bg-white shadow rounded-lg p-6 no-print">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">📥 Descargar Reporte</h2>
        <div class="flex flex-wrap gap-3">
          <button
            @click="downloadPDF"
            class="flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
          >
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path d="M8 2a1 1 0 000 2h2a1 1 0 100-2H8z"/>
              <path d="M3 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v6h-4.586l1.293-1.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L10.414 13H15v3a2 2 0 01-2 2H5a2 2 0 01-2-2V5zM15 11h2a1 1 0 110 2h-2v-2z"/>
            </svg>
            Descargar PDF
          </button>
          <button
            @click="downloadExcel"
            class="flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition"
          >
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"/>
            </svg>
            Descargar Excel
          </button>
          <button
            @click="printReport"
            class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
          >
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"/>
            </svg>
            Imprimir
          </button>
        </div>
        <p class="text-sm text-gray-500 mt-3">
          💡 Los archivos se generarán con los {{ stats.total }} registros mostrados según los filtros aplicados
        </p>
      </div>

      <!-- Tabla de Resultados -->
      <div class="bg-white shadow overflow-hidden rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <div class="flex justify-between items-center">
            <p class="text-sm font-medium text-gray-700">
              📋 Mostrando {{ attendances.length }} registro(s)
            </p>
            <div class="text-sm text-gray-500">
              {{ filters.start_date && filters.end_date 
                ? `Del ${formatDate(filters.start_date)} al ${formatDate(filters.end_date)}` 
                : 'Todos los periodos' }}
            </div>
          </div>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carrera</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fuente</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-if="attendances.length === 0">
                <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                  <div class="flex flex-col items-center">
                    <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-lg font-medium">No hay registros</p>
                    <p class="text-sm">Intenta con diferentes filtros o verifica que haya asistencias registradas</p>
                  </div>
                </td>
              </tr>
              <tr v-for="(record, index) in attendances" :key="record.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ index + 1 }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ record.student_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ record.student_dni }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ record.student_code }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                    {{ record.career }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ record.date_formatted }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ record.time }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    :class="getStatusClass(record.status)"
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                  >
                    {{ getStatusLabel(record.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
                    {{ record.source === 'public' ? '🌐 Web' : record.source === 'gate' ? '🚪 Portal' : '✍️ Manual' }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  attendances: Array,
  stats: Object,
  careerStats: Array,
  careers: Array,
  students: Array,
  filters: Object
});

const filters = ref({
  start_date: props.filters.start_date || '',
  end_date: props.filters.end_date || '',
  career_id: props.filters.career_id || '',
  status: props.filters.status || '',
  student_id: props.filters.student_id || '',
});

const applyFilters = () => {
  router.get('/reports/attendance', filters.value, {
    preserveState: true,
    preserveScroll: true,
  });
};

const clearFilters = () => {
  filters.value = {
    start_date: '',
    end_date: '',
    career_id: '',
    status: '',
    student_id: '',
  };
  applyFilters();
};

const getStatusClass = (status) => {
  const classes = {
    'present': 'bg-green-100 text-green-800',
    'absent': 'bg-red-100 text-red-800',
    'late': 'bg-yellow-100 text-yellow-800',
    'justified': 'bg-blue-100 text-blue-800',
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};

const getStatusLabel = (status) => {
  const labels = {
    'present': 'Presente',
    'absent': 'Ausente',
    'late': 'Tarde',
    'justified': 'Justificado',
  };
  return labels[status] || status;
};

const getPercentage = (value, total) => {
  if (total === 0) return 0;
  return Math.round((value / total) * 100);
};

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
};

const downloadPDF = () => {
  const params = new URLSearchParams(filters.value);
  window.location.href = `/reports/attendance/download/pdf?${params.toString()}`;
};

const downloadExcel = () => {
  const params = new URLSearchParams(filters.value);
  window.location.href = `/reports/attendance/download/excel?${params.toString()}`;
};

const printReport = () => {
  window.print();
};
</script>

<style>
@media print {
  .no-print {
    display: none !important;
  }
}
</style>
