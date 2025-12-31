<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">📋 Control de Asistencia</h1>
          <p class="mt-2 text-gray-600">Todas las asistencias registradas desde el sistema público</p>
        </div>
        <Link
          href="/attendance/register"
          class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
        >
          + Registrar Asistencia Manual
        </Link>
      </div>

      <!-- Filters -->
      <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">🔍 Buscar DNI/Nombre</label>
            <input
              v-model="searchTerm"
              type="text"
              placeholder="Buscar por DNI o nombre..."
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📅 Fecha</label>
            <input
              v-model="selectedDate"
              type="date"
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">🎓 Carrera</label>
            <select 
              v-model="selectedCareer"
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Todas las Carreras</option>
              <option value="Producción Agropecuaria">Producción Agropecuaria</option>
              <option value="Contabilidad">Contabilidad</option>
              <option value="Desarrollo de Software">Desarrollo de Software</option>
              <option value="Gastronomía">Gastronomía</option>
              <option value="Enfermería Técnica">Enfermería Técnica</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">✅ Estado</label>
            <select 
              v-model="selectedStatus"
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Todos los Estados</option>
              <option value="present">Presente</option>
              <option value="late">Tarde</option>
              <option value="absent">Ausente</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Attendance Summary -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-5">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
          <p class="text-sm text-blue-700 font-medium">📊 Total Registros</p>
          <p class="text-2xl font-bold text-blue-900 mt-1">{{ stats.total }}</p>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
          <p class="text-sm text-purple-700 font-medium">📅 Hoy</p>
          <p class="text-2xl font-bold text-purple-900 mt-1">{{ stats.today }}</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
          <p class="text-sm text-green-700 font-medium">✅ Presente</p>
          <p class="text-2xl font-bold text-green-900 mt-1">{{ stats.present }}</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
          <p class="text-sm text-yellow-700 font-medium">⏰ Tarde</p>
          <p class="text-2xl font-bold text-yellow-900 mt-1">{{ stats.late }}</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
          <p class="text-sm text-red-700 font-medium">❌ Ausente</p>
          <p class="text-2xl font-bold text-red-900 mt-1">{{ stats.absent }}</p>
        </div>
      </div>

      <!-- Attendance Records -->
      <div class="bg-white shadow overflow-hidden rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <p class="text-sm font-medium text-gray-700">
            Mostrando {{ filteredAttendances.length }} de {{ attendances.length }} registros totales
          </p>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
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
              <tr v-if="filteredAttendances.length === 0">
                <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                  <div class="flex flex-col items-center">
                    <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-lg font-medium">No hay registros de asistencia</p>
                    <p class="text-sm">Los estudiantes deben ingresar su DNI en la página principal</p>
                  </div>
                </td>
              </tr>
              <tr v-for="record in filteredAttendances" :key="record.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">#{{ record.id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ record.student_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ record.student_dni }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ record.student_code }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                    {{ record.career }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ record.date }}</td>
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
                    {{ record.source === 'public' ? '🌐 Web Público' : record.source === 'gate' ? '🚪 Portal' : '✍️ Manual' }}
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
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  attendances: Array,
  stats: Object
});

const searchTerm = ref('');
const selectedDate = ref('');
const selectedCareer = ref('');
const selectedStatus = ref('');

// Filtrar asistencias según los criterios
const filteredAttendances = computed(() => {
  let filtered = props.attendances || [];

  // Filtrar por término de búsqueda
  if (searchTerm.value) {
    const term = searchTerm.value.toLowerCase();
    filtered = filtered.filter(a => 
      a.student_name.toLowerCase().includes(term) ||
      a.student_dni.includes(term) ||
      a.student_code.toLowerCase().includes(term)
    );
  }

  // Filtrar por fecha
  if (selectedDate.value) {
    filtered = filtered.filter(a => {
      const recordDate = a.date.split('/').reverse().join('-'); // Convertir dd/mm/yyyy a yyyy-mm-dd
      return recordDate === selectedDate.value;
    });
  }

  // Filtrar por carrera
  if (selectedCareer.value) {
    filtered = filtered.filter(a => a.career === selectedCareer.value);
  }

  // Filtrar por estado
  if (selectedStatus.value) {
    filtered = filtered.filter(a => a.status === selectedStatus.value);
  }

  return filtered;
});

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
</script>
