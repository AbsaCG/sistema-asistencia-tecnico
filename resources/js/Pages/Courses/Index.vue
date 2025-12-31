<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">📚 Gestión de Cursos</h1>
          <p class="mt-2 text-gray-600">Administra las unidades didácticas del instituto</p>
        </div>
        <Link href="/courses/create" 
              class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
          <span class="mr-2">➕</span> Nuevo Curso
        </Link>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                <span class="text-2xl">📚</span>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Cursos</dt>
                  <dd class="text-2xl font-semibold text-gray-900">{{ courses.length }}</dd>
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
                  <dd class="text-2xl font-semibold text-gray-900">{{ courses.filter(c => c.status === 'active').length }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
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

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                <span class="text-2xl">📊</span>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Créditos</dt>
                  <dd class="text-2xl font-semibold text-gray-900">{{ totalCredits }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Search and Filters -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">🔍 Buscar</label>
            <input 
              v-model="searchQuery"
              type="text" 
              placeholder="Código o nombre..." 
              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">🎓 Carrera</label>
            <select 
              v-model="filterCareer"
              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Todas las carreras</option>
              <option v-for="career in careers" :key="career" :value="career">{{ career }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📊 Ciclo</label>
            <select 
              v-model="filterCycle"
              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Todos los ciclos</option>
              <option value="1">I Ciclo</option>
              <option value="2">II Ciclo</option>
              <option value="3">III Ciclo</option>
              <option value="4">IV Ciclo</option>
              <option value="5">V Ciclo</option>
              <option value="6">VI Ciclo</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📈 Estado</label>
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

      <!-- Courses Table -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unidad Didáctica</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">🎓 Carrera</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciclo</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créditos</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horas</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                  <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="course in filteredCourses" :key="course.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ course.code }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ course.name }}</div>
                    <div v-if="course.teacher" class="text-sm text-gray-500">👨‍🏫 {{ course.teacher }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-md text-xs font-medium">
                      {{ course.career || '—' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ course.cycle ? `${course.cycle}° Ciclo` : '—' }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ course.credits || 0 }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ course.hours || 0 }}h/sem</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="['px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                   course.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800']">
                      {{ course.status === 'active' ? '✅ Activo' : '❌ Inactivo' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button @click="viewCourse(course.id)" class="text-indigo-600 hover:text-indigo-900 mr-3">👁️ Ver</button>
                    <button @click="editCourse(course.id)" class="text-blue-600 hover:text-blue-900 mr-3">✏️ Editar</button>
                    <button @click="confirmDelete(course.id, course.name)" class="text-red-600 hover:text-red-900">🗑️ Eliminar</button>
                  </td>
                </tr>
                <tr v-if="filteredCourses.length === 0">
                  <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                    <div class="text-4xl mb-2">🔍</div>
                    <div>No se encontraron cursos</div>
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
  courses: {
    type: Array,
    default: () => []
  }
});

const searchQuery = ref('');
const filterCareer = ref('');
const filterCycle = ref('');
const filterStatus = ref('');

const careers = computed(() => {
  return [...new Set(props.courses.map(c => c.career).filter(Boolean))];
});

const uniqueCareers = computed(() => careers.value.length);

const totalCredits = computed(() => {
  return props.courses.reduce((sum, c) => sum + (c.credits || 0), 0);
});

const filteredCourses = computed(() => {
  let result = props.courses;
  
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    result = result.filter(c => 
      c.name.toLowerCase().includes(query) ||
      c.code.toLowerCase().includes(query)
    );
  }
  
  if (filterCareer.value) {
    result = result.filter(c => c.career === filterCareer.value);
  }
  
  if (filterCycle.value) {
    result = result.filter(c => String(c.cycle) === filterCycle.value);
  }
  
  if (filterStatus.value) {
    result = result.filter(c => c.status === filterStatus.value);
  }
  
  return result;
});

const viewCourse = (id) => {
  router.visit(`/courses/${id}`);
};

const editCourse = (id) => {
  router.visit(`/courses/${id}/edit`);
};

const confirmDelete = (id, name) => {
  if (confirm(`¿Estás seguro de eliminar el curso "${name}"?`)) {
    router.delete(`/courses/${id}`, {
      onSuccess: () => {
        alert('Curso eliminado exitosamente');
      }
    });
  }
};
</script>
