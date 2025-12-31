<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">👥 Gestión de Estudiantes</h1>
          <p class="mt-2 text-gray-600">Administra el registro de estudiantes del instituto</p>
        </div>
        <Link href="/students/create" 
              class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
          <span class="mr-2">➕</span> Nuevo Estudiante
        </Link>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                <span class="text-2xl">👨‍🎓</span>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Estudiantes</dt>
                  <dd class="text-2xl font-semibold text-gray-900">{{ students.length }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                <span class="text-2xl">✅</span>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Activos</dt>
                  <dd class="text-2xl font-semibold text-gray-900">{{ students.filter(s => s.status === 'active').length }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                <span class="text-2xl">🎓</span>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Carreras</dt>
                  <dd class="text-2xl font-semibold text-gray-900">{{ uniqueCareers }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Search & Filter -->
      <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="🔍 Buscar por nombre, código, DNI..."
            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          />
          <select v-model="filterCareer" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">🎓 Todas las Carreras</option>
            <option v-for="career in careers" :key="career" :value="career">{{ career }}</option>
          </select>
          <select v-model="filterStatus" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">📊 Todos los Estados</option>
            <option value="active">✅ Activos</option>
            <option value="inactive">❌ Inactivos</option>
          </select>
        </div>
      </div>

      <!-- Students Table -->
      <div class="bg-white shadow overflow-hidden rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">🎓 Carrera</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                  <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="student in filteredStudents" :key="student.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-indigo-600 font-semibold text-sm">{{ student.initials }}</span>
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ student.name }}</div>
                        <div class="text-sm text-gray-500">{{ student.email }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ student.dni }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ student.code }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-md text-xs font-medium">
                      {{ student.career || '—' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="['px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                   student.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800']">
                      {{ student.status === 'active' ? '✅ Activo' : '❌ Inactivo' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button @click="viewStudent(student.id)" class="text-indigo-600 hover:text-indigo-900 mr-3">👁️ Ver</button>
                    <button @click="editStudent(student.id)" class="text-blue-600 hover:text-blue-900 mr-3">✏️ Editar</button>
                    <button @click="confirmDelete(student.id, student.name)" class="text-red-600 hover:text-red-900">🗑️ Eliminar</button>
                  </td>
                </tr>
                <tr v-if="filteredStudents.length === 0">
                  <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                    <div class="text-4xl mb-2">🔍</div>
                    <div>No se encontraron estudiantes</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
  students: {
    type: Array,
    default: () => []
  }
});

const searchQuery = ref('');
const filterCareer = ref('');
const filterStatus = ref('');

const careers = computed(() => {
  return [...new Set(props.students.map(s => s.career).filter(Boolean))];
});

const uniqueCareers = computed(() => careers.value.length);

const filteredStudents = computed(() => {
  let result = props.students;
  
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    result = result.filter(s => 
      s.name.toLowerCase().includes(query) ||
      s.dni.includes(query) ||
      s.code.toLowerCase().includes(query) ||
      s.email.toLowerCase().includes(query)
    );
  }
  
  if (filterCareer.value) {
    result = result.filter(s => s.career === filterCareer.value);
  }
  
  if (filterStatus.value) {
    result = result.filter(s => s.status === filterStatus.value);
  }
  
  return result;
});

const viewStudent = (id) => {
  router.visit(`/students/${id}`);
};

const editStudent = (id) => {
  router.visit(`/students/${id}/edit`);
};

const confirmDelete = (id, name) => {
  if (confirm(`¿Estás seguro de eliminar al estudiante "${name}"?`)) {
    router.delete(`/students/${id}`, {
      onSuccess: () => {
        alert('Estudiante eliminado exitosamente');
      }
    });
  }
};
</script>
