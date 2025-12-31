<template>
  <AppLayout title="Editar Estudiante">
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900">✏️ Editar Estudiante</h2>
          </div>

          <form @submit.prevent="submitForm" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Nombre Completo -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                <input 
                  v-model="form.name" 
                  type="text" 
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <!-- Email -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input 
                  v-model="form.email" 
                  type="email" 
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <!-- DNI -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">DNI *</label>
                <input 
                  v-model="form.dni" 
                  type="text" 
                  required
                  maxlength="8"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <!-- Código -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Código de Estudiante *</label>
                <input 
                  v-model="form.code" 
                  type="text" 
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <!-- Carrera -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Carrera Técnica</label>
                <select 
                  v-model="form.technical_career_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option :value="null">Sin carrera asignada</option>
                  <option 
                    v-for="career in careers" 
                    :key="career.id" 
                    :value="career.id"
                  >
                    {{ career.name }}
                  </option>
                </select>
              </div>

              <!-- Teléfono -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                <input 
                  v-model="form.phone" 
                  type="text" 
                  maxlength="15"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <!-- Dirección -->
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                <input 
                  v-model="form.address" 
                  type="text" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-3 mt-6">
              <Link 
                href="/students"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
              >
                Cancelar
              </Link>
              <button 
                type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition"
                :disabled="processing"
              >
                {{ processing ? 'Guardando...' : '💾 Guardar Cambios' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
  student: Object,
  careers: Array
});

const form = ref({
  name: props.student.name,
  email: props.student.email,
  dni: props.student.dni,
  code: props.student.code,
  technical_career_id: props.student.technical_career_id,
  phone: props.student.phone,
  address: props.student.address
});

const processing = ref(false);

const submitForm = () => {
  processing.value = true;
  router.put(`/students/${props.student.id}`, form.value, {
    onFinish: () => {
      processing.value = false;
    }
  });
};
</script>
