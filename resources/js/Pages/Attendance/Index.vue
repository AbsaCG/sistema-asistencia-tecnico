<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Control de Asistencia</h1>
          <p class="mt-2 text-gray-600">Registro y gestión de asistencia diaria</p>
        </div>
        <Link
          href="/attendance/register"
          class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
        >
          + Registrar Asistencia
        </Link>
      </div>

      <!-- Filters -->
      <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
            <input
              v-model="selectedDate"
              type="date"
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Grado</label>
            <select class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">Todos los Grados</option>
              <option value="1">1ro de Primaria</option>
              <option value="2">2do de Primaria</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sección</label>
            <select class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">Todas las Secciones</option>
              <option value="A">A</option>
              <option value="B">B</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Attendance Summary -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
          <p class="text-sm text-green-700 font-medium">Presente</p>
          <p class="text-2xl font-bold text-green-900 mt-1">450</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
          <p class="text-sm text-red-700 font-medium">Ausente</p>
          <p class="text-2xl font-bold text-red-900 mt-1">45</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
          <p class="text-sm text-yellow-700 font-medium">Tarde</p>
          <p class="text-2xl font-bold text-yellow-900 mt-1">32</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
          <p class="text-sm text-blue-700 font-medium">Justificado</p>
          <p class="text-2xl font-bold text-blue-900 mt-1">18</p>
        </div>
      </div>

      <!-- Attendance Records -->
      <div class="bg-white shadow overflow-hidden rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grado</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registrado por</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="record in attendanceRecords" :key="record.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ record.studentName }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ record.grade }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ record.date }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                  :class="getStatusClass(record.status)"
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                >
                  {{ record.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ record.registeredBy }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <button class="text-indigo-600 hover:text-indigo-900">Editar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

const selectedDate = ref(new Date().toISOString().split('T')[0]);

const attendanceRecords = ref([
  { id: 1, studentName: 'Juan Pérez', grade: '1ro A', date: '2025-12-30', status: 'Presente', registeredBy: 'Prof. Ana' },
  { id: 2, studentName: 'María García', grade: '1ro A', date: '2025-12-30', status: 'Presente', registeredBy: 'Prof. Ana' },
  { id: 3, studentName: 'Carlos López', grade: '1ro B', date: '2025-12-30', status: 'Ausente', registeredBy: 'Prof. Luis' },
  { id: 4, studentName: 'Elena Sánchez', grade: '1ro A', date: '2025-12-30', status: 'Tarde', registeredBy: 'Prof. Ana' },
]);

const getStatusClass = (status) => {
  const classes = {
    'Presente': 'bg-green-100 text-green-800',
    'Ausente': 'bg-red-100 text-red-800',
    'Tarde': 'bg-yellow-100 text-yellow-800',
    'Justificado': 'bg-blue-100 text-blue-800',
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};
</script>
