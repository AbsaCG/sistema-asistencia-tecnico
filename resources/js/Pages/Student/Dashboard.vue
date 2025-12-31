<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header del Estudiante -->
      <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center space-x-4">
          <div class="bg-white bg-opacity-20 rounded-full p-4">
            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div>
            <h1 class="text-3xl font-bold">{{ student.name }}</h1>
            <div class="mt-2 space-y-1">
              <p class="text-indigo-100">📋 Código: <span class="font-semibold">{{ student.code }}</span></p>
              <p class="text-indigo-100">🆔 DNI: <span class="font-semibold">{{ student.dni }}</span></p>
              <p class="text-indigo-100">🎓 Carrera: <span class="font-semibold">{{ student.career }}</span></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Estadísticas del Mes Actual -->
      <div>
        <h2 class="text-xl font-semibold text-gray-900 mb-4">📅 Asistencias de {{ currentMonth }}</h2>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-5">
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-blue-700 font-medium">📊 Total</p>
            <p class="text-3xl font-bold text-blue-900 mt-1">{{ monthStats.total }}</p>
          </div>
          <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-sm text-green-700 font-medium">✅ Presente</p>
            <p class="text-3xl font-bold text-green-900 mt-1">{{ monthStats.present }}</p>
            <p class="text-xs text-green-600 mt-1">{{ getPercentage(monthStats.present, monthStats.total) }}%</p>
          </div>
          <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-sm text-yellow-700 font-medium">⏰ Tarde</p>
            <p class="text-3xl font-bold text-yellow-900 mt-1">{{ monthStats.late }}</p>
            <p class="text-xs text-yellow-600 mt-1">{{ getPercentage(monthStats.late, monthStats.total) }}%</p>
          </div>
          <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <p class="text-sm text-red-700 font-medium">❌ Ausente</p>
            <p class="text-3xl font-bold text-red-900 mt-1">{{ monthStats.absent }}</p>
            <p class="text-xs text-red-600 mt-1">{{ getPercentage(monthStats.absent, monthStats.total) }}%</p>
          </div>
          <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
            <p class="text-sm text-purple-700 font-medium">📝 Justificado</p>
            <p class="text-3xl font-bold text-purple-900 mt-1">{{ monthStats.justified }}</p>
            <p class="text-xs text-purple-600 mt-1">{{ getPercentage(monthStats.justified, monthStats.total) }}%</p>
          </div>
        </div>
      </div>

      <!-- Estadísticas Totales -->
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">📈 Estadísticas Generales (Todo el tiempo)</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
          <div class="text-center">
            <p class="text-2xl font-bold text-gray-900">{{ allTimeStats.total }}</p>
            <p class="text-sm text-gray-600">Total</p>
          </div>
          <div class="text-center">
            <p class="text-2xl font-bold text-green-600">{{ allTimeStats.present }}</p>
            <p class="text-sm text-gray-600">Presente</p>
          </div>
          <div class="text-center">
            <p class="text-2xl font-bold text-yellow-600">{{ allTimeStats.late }}</p>
            <p class="text-sm text-gray-600">Tarde</p>
          </div>
          <div class="text-center">
            <p class="text-2xl font-bold text-red-600">{{ allTimeStats.absent }}</p>
            <p class="text-sm text-gray-600">Ausente</p>
          </div>
          <div class="text-center">
            <p class="text-2xl font-bold text-purple-600">{{ allTimeStats.justified }}</p>
            <p class="text-sm text-gray-600">Justificado</p>
          </div>
        </div>
      </div>

      <!-- Últimas Asistencias -->
      <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-900">🕐 Últimas Asistencias</h3>
          <a :href="route('student.my-attendances')" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            Ver todas →
          </a>
        </div>
        
        <div v-if="recentAttendances.length === 0" class="text-center py-8 text-gray-500">
          <p>No hay registros de asistencia</p>
        </div>
        
        <div v-else class="space-y-3">
          <div v-for="attendance in recentAttendances" :key="attendance.date" 
               class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
            <div class="flex-1">
              <p class="font-semibold text-gray-900">{{ attendance.course }}</p>
              <p class="text-sm text-gray-600">{{ attendance.date }} - {{ attendance.time }}</p>
            </div>
            <span
              :class="getStatusClass(attendance.status)"
              class="px-3 py-1 text-xs font-semibold rounded-full"
            >
              {{ getStatusLabel(attendance.status) }}
            </span>
          </div>
        </div>
      </div>

      <!-- Acciones Rápidas -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a :href="route('student.my-attendances')" 
           class="block p-6 bg-white shadow rounded-lg hover:shadow-lg transition">
          <div class="flex items-center space-x-3">
            <div class="bg-indigo-100 rounded-full p-3">
              <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div>
              <h4 class="font-semibold text-gray-900">Mis Asistencias</h4>
              <p class="text-sm text-gray-600">Ver historial completo</p>
            </div>
          </div>
        </a>

        <a :href="route('student.schedule')" 
           class="block p-6 bg-white shadow rounded-lg hover:shadow-lg transition">
          <div class="flex items-center space-x-3">
            <div class="bg-green-100 rounded-full p-3">
              <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div>
              <h4 class="font-semibold text-gray-900">Mi Horario</h4>
              <p class="text-sm text-gray-600">Ver clases programadas</p>
            </div>
          </div>
        </a>

        <a :href="route('student.justifications')" 
           class="block p-6 bg-white shadow rounded-lg hover:shadow-lg transition">
          <div class="flex items-center space-x-3">
            <div class="bg-purple-100 rounded-full p-3">
              <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div>
              <h4 class="font-semibold text-gray-900">Justificaciones</h4>
              <p class="text-sm text-gray-600">Subir documentos</p>
            </div>
          </div>
        </a>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  student: Object,
  monthStats: Object,
  allTimeStats: Object,
  recentAttendances: Array,
  currentMonth: String,
});

const getPercentage = (value, total) => {
  if (total === 0) return 0;
  return Math.round((value / total) * 100);
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
</script>
