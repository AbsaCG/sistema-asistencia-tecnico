<template>
  <AppLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Crear Estudiante</h1>
        <p class="mt-2 text-gray-600">Agregar un nuevo estudiante al sistema</p>
      </div>

      <div class="bg-white shadow rounded-lg p-8">
        <form @submit.prevent="submit" class="space-y-6">
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
              <input v-model="form.name" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">DNI</label>
              <input v-model="form.dni" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Código Estudiante</label>
              <input v-model="form.code" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
              <input v-model="form.birthDate" type="date" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email (generará usuario)</label>
              <input v-model="form.email" type="email" placeholder="estudiante@email.com" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">🎓 Carrera Técnica</label>
              <select v-model="form.technical_career_id" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecciona una carrera</option>
                <option v-for="career in careers" :key="career.id" :value="career.id">
                  {{ career.name }}
                </option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Semestre</label>
              <select v-model="form.semester" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecciona semestre</option>
                <option value="1">1er Semestre</option>
                <option value="2">2do Semestre</option>
                <option value="3">3er Semestre</option>
                <option value="4">4to Semestre</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
              <input v-model="form.phone" type="tel" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
          </div>

          <div class="border-t pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Datos del Apoderado</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Apoderado</label>
                <input v-model="form.parentName" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email del Apoderado</label>
                <input v-model="form.parentEmail" type="email" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono del Apoderado</label>
                <input v-model="form.parentPhone" type="tel" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
              </div>
            </div>
          </div>

          <div class="flex justify-end space-x-3">
            <Link href="/students" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
              Cancelar
            </Link>
            <button type="submit" :disabled="processing" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50">
              <span v-if="processing">Creando...</span>
              <span v-else>Crear Estudiante</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  careers: {
    type: Array,
    default: () => [],
  },
});

const form = ref({
  name: '',
  dni: '',
  code: '',
  email: '',
  birthDate: '',
  technical_career_id: '',
  semester: '',
  phone: '',
  parentName: '',
  parentEmail: '',
  parentPhone: '',
});

const processing = ref(false);

const submit = () => {
  processing.value = true;
  
  router.post('/students', form.value, {
    onSuccess: () => {
      processing.value = false;
    },
    onError: (errors) => {
      processing.value = false;
      console.error('Errores:', errors);
      alert('Error al crear estudiante. Revisa los campos.');
    },
  });
};
</script>
