<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Estudiantes</h1>
          <p class="mt-2 text-gray-600">Gestión de estudiantes del sistema</p>
        </div>
        <Link
          href="/students/create"
          class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
        >
          + Nuevo Estudiante
        </Link>
      </div>

      <!-- Search & Filter -->
      <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Buscar por nombre, código..."
            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          />
          <select class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Todos los Grados</option>
            <option value="1">1ro de Primaria</option>
            <option value="2">2do de Primaria</option>
            <option value="3">3ro de Primaria</option>
          </select>
          <select class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Todos los Estados</option>
            <option value="active">Activo</option>
            <option value="inactive">Inactivo</option>
          </select>
        </div>
      </div>

      <!-- Students Table -->
      <div class="bg-white shadow overflow-hidden rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grado</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="student in students" :key="student.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ student.code }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ student.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ student.grade }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ student.dni }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ student.phone }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="student.active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                  {{ student.active ? 'Activo' : 'Inactivo' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</button>
                <button class="text-red-600 hover:text-red-900">Eliminar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Empty State -->
      <div v-if="students.length === 0" class="text-center py-12">
        <span class="text-5xl">📚</span>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay estudiantes</h3>
        <p class="mt-1 text-sm text-gray-500">Comienza agregando tu primer estudiante.</p>
        <div class="mt-6">
          <Link
            href="/students/create"
            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
          >
            Crear Estudiante
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

const searchQuery = ref('');
const students = ref([
  { id: 1, code: 'EST001', name: 'Juan Pérez', grade: '1ro A', dni: '12345678', phone: '998765432', active: true },
  { id: 2, code: 'EST002', name: 'María García', grade: '1ro A', dni: '87654321', phone: '998765433', active: true },
  { id: 3, code: 'EST003', name: 'Carlos López', grade: '1ro B', dni: '11223344', phone: '998765434', active: false },
]);
</script>
