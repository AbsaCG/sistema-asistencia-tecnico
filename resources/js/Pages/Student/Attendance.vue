<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Mi Asistencia</h1>
        <p class="mt-2 text-gray-600">Registro completo de mi asistencia</p>
      </div>

      <!-- Resumen -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white shadow rounded-lg p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Total Clases</p>
              <p class="text-3xl font-bold text-gray-900">{{ summary.total }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
              <span class="text-2xl">📚</span>
            </div>
          </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Presente</p>
              <p class="text-3xl font-bold text-green-600">{{ summary.present }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
              <span class="text-2xl">✅</span>
            </div>
          </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Ausente</p>
              <p class="text-3xl font-bold text-red-600">{{ summary.absent }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
              <span class="text-2xl">❌</span>
            </div>
          </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Porcentaje</p>
              <p class="text-3xl font-bold text-indigo-600">{{ summary.percentage }}%</p>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
              <span class="text-2xl">📊</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Filtros -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Curso</label>
            <select class="w-full border-gray-300 rounded-lg">
              <option value="">Todos los cursos</option>
              <option v-for="course in courses" :key="course.id" :value="course.id">
                {{ course.name }}
              </option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicio</label>
            <input type="date" class="w-full border-gray-300 rounded-lg" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin</label>
            <input type="date" class="w-full border-gray-300 rounded-lg" />
          </div>
        </div>
      </div>

      <!-- Tabla de Asistencia -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Profesor</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hora</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Observaciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="record in attendanceRecords" :key="record.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ formatDate(record.date) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ record.course_name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                {{ record.teacher_name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="[
                  record.status === 'present' ? 'bg-green-100 text-green-800' : 
                  record.status === 'absent' ? 'bg-red-100 text-red-800' : 
                  'bg-yellow-100 text-yellow-800',
                  'px-2 py-1 rounded-full text-xs font-medium'
                ]">
                  {{ record.status === 'present' ? 'Presente' : record.status === 'absent' ? 'Ausente' : 'Tardanza' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                {{ record.time }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-600">
                {{ record.notes || '-' }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  summary: {
    type: Object,
    required: true
  },
  attendanceRecords: {
    type: Array,
    required: true
  },
  courses: {
    type: Array,
    required: true
  }
});

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-ES', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  });
};
</script>
