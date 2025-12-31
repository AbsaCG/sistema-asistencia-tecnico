<template>
  <AppLayout title="Editar Profesor">
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900">✏️ Editar Profesor</h2>
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Código de Docente *</label>
                <input 
                  v-model="form.code" 
                  type="text" 
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <!-- Especialidad -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Especialidad</label>
                <input 
                  v-model="form.specialization" 
                  type="text" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
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

              <!-- Estado -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select 
                  v-model="form.active"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option :value="true">Activo</option>
                  <option :value="false">Inactivo</option>
                </select>
              </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-3 mt-6">
              <Link 
                href="/teachers"
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
  teacher: Object
});

const form = ref({
  name: props.teacher.name,
  email: props.teacher.email,
  dni: props.teacher.dni,
  code: props.teacher.code,
  specialization: props.teacher.specialization,
  phone: props.teacher.phone,
  address: props.teacher.address,
  active: props.teacher.active
});

const processing = ref(false);

const submitForm = () => {
  processing.value = true;
  router.put(`/teachers/${props.teacher.id}`, form.value, {
    onFinish: () => {
      processing.value = false;
    }
  });
};
</script>
