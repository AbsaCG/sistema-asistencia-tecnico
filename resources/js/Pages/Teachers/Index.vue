<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">👨‍🏫 Gestión de Profesores</h1>
          <p class="mt-2 text-gray-600">Administra el equipo docente del instituto</p>
        </div>
        <Link href="/teachers/create" 
              class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
          <span class="mr-2">➕</span> Nuevo Profesor
        </Link>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                <span class="text-2xl">👨‍🏫</span>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Profesores</dt>
                  <dd class="text-2xl font-semibold text-gray-900">{{ teachers.length }}</dd>
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
                  <dd class="text-2xl font-semibold text-gray-900">{{ teachers.filter(t => t.status === 'active').length }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                <span class="text-2xl">📚</span>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Cursos</dt>
                  <dd class="text-2xl font-semibold text-gray-900">{{ totalCourses }}</dd>
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
                  <dt class="text-sm font-medium text-gray-500 truncate">Especialidades</dt>
                  <dd class="text-2xl font-semibold text-gray-900">{{ uniqueSpecialties }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Search and Filters -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">🔍 Buscar</label>
            <input 
              v-model="searchQuery"
              type="text" 
              placeholder="DNI, nombre o código..." 
              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">🎓 Especialidad</label>
            <select 
              v-model="filterSpecialty"
              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Todas</option>
              <option v-for="specialty in specialties" :key="specialty" :value="specialty">{{ specialty }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📊 Estado</label>
            <select 
              v-model="filterStatus"
              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Todos</option>
              <option value="active">✅ Activo</option>
              <option value="inactive">❌ Inactivo</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Teachers Table -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profesor</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Especialidad</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cursos</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                  <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="teacher in filteredTeachers" :key="teacher.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-indigo-600 font-semibold text-sm">{{ teacher.initials }}</span>
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ teacher.name }}</div>
                        <div class="text-sm text-gray-500">{{ teacher.email }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ teacher.dni }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ teacher.code }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-md text-xs font-medium">
                      {{ teacher.specialty || '—' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ teacher.courses_count || 0 }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="['px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                   teacher.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800']">
                      {{ teacher.status === 'active' ? '✅ Activo' : '❌ Inactivo' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button @click="viewTeacher(teacher.id)" class="text-indigo-600 hover:text-indigo-900 mr-3">👁️ Ver</button>
                    <button @click="editTeacher(teacher.id)" class="text-blue-600 hover:text-blue-900 mr-3">✏️ Editar</button>
                    <button @click="confirmDelete(teacher.id, teacher.name)" class="text-red-600 hover:text-red-900">🗑️ Eliminar</button>
                  </td>
                </tr>
                <tr v-if="filteredTeachers.length === 0">
                  <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                    <div class="text-4xl mb-2">🔍</div>
                    <div>No se encontraron profesores</div>
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
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  teachers: {
    type: Array,
    default: () => []
  }
});

const searchQuery = ref('');
const filterSpecialty = ref('');
const filterStatus = ref('');

const specialties = computed(() => {
  return [...new Set(props.teachers.map(t => t.specialty).filter(Boolean))];
});

const uniqueSpecialties = computed(() => specialties.value.length);

const totalCourses = computed(() => {
  return props.teachers.reduce((sum, t) => sum + (t.courses_count || 0), 0);
});

const filteredTeachers = computed(() => {
  let result = props.teachers;
  
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    result = result.filter(t => 
      t.name.toLowerCase().includes(query) ||
      t.dni.includes(query) ||
      t.code.toLowerCase().includes(query) ||
      t.email.toLowerCase().includes(query)
    );
  }
  
  if (filterSpecialty.value) {
    result = result.filter(t => t.specialty === filterSpecialty.value);
  }
  
  if (filterStatus.value) {
    result = result.filter(t => t.status === filterStatus.value);
  }
  
  return result;
});

const viewTeacher = (id) => {
  router.visit(`/teachers/${id}`);
};

const editTeacher = (id) => {
  router.visit(`/teachers/${id}/edit`);
};

const confirmDelete = (id, name) => {
  if (confirm(`¿Estás seguro de eliminar al profesor "${name}"?`)) {
    router.delete(`/teachers/${id}`, {
      onSuccess: () => {
        alert('Profesor eliminado exitosamente');
      }
    });
  }
};
</script>
