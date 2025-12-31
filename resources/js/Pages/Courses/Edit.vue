<template>
  <AppLayout title="Editar Unidad Didáctica">
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900">✏️ Editar Unidad Didáctica</h2>
          </div>

          <form @submit.prevent="submitForm" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Código -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Código *</label>
                <input 
                  v-model="form.code" 
                  type="text" 
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <!-- Nombre -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Unidad *</label>
                <input 
                  v-model="form.name" 
                  type="text" 
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <!-- Descripción -->
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea 
                  v-model="form.description" 
                  rows="3"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
              </div>

              <!-- Carrera -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Carrera Técnica</label>
                <select 
                  v-model="form.technical_career_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option :value="null">Transversal (todas las carreras)</option>
                  <option 
                    v-for="career in careers" 
                    :key="career.id" 
                    :value="career.id"
                  >
                    {{ career.name }}
                  </option>
                </select>
              </div>

              <!-- Ciclo -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ciclo *</label>
                <select 
                  v-model="form.cycle"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option :value="1">I Ciclo</option>
                  <option :value="2">II Ciclo</option>
                  <option :value="3">III Ciclo</option>
                  <option :value="4">IV Ciclo</option>
                  <option :value="5">V Ciclo</option>
                  <option :value="6">VI Ciclo</option>
                </select>
              </div>

              <!-- Créditos -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Créditos *</label>
                <input 
                  v-model.number="form.credits" 
                  type="number" 
                  min="0"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <!-- Horas por semana -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Horas por Semana *</label>
                <input 
                  v-model.number="form.hours" 
                  type="number" 
                  min="0"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-3 mt-6">
              <Link 
                href="/courses"
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
  course: Object,
  careers: Array
});

const form = ref({
  code: props.course.code,
  name: props.course.name,
  description: props.course.description,
  technical_career_id: props.course.technical_career_id,
  cycle: props.course.cycle,
  credits: props.course.credits,
  hours: props.course.hours
});

const processing = ref(false);

const submitForm = () => {
  processing.value = true;
  router.put(`/courses/${props.course.id}`, form.value, {
    onFinish: () => {
      processing.value = false;
    }
  });
};
</script>
