<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Mis Justificaciones</h1>
          <p class="mt-2 text-gray-600">Gestiona justificaciones de inasistencias</p>
        </div>
        <button @click="showModal = true" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center">
          <span class="mr-2">+</span> Nueva Justificación
        </button>
      </div>

      <!-- Estadísticas -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white shadow rounded-lg p-6">
          <p class="text-sm text-gray-600">Total</p>
          <p class="text-3xl font-bold text-gray-900">{{ stats.total }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
          <p class="text-sm text-gray-600">Aprobadas</p>
          <p class="text-3xl font-bold text-green-600">{{ stats.approved }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
          <p class="text-sm text-gray-600">Pendientes</p>
          <p class="text-3xl font-bold text-yellow-600">{{ stats.pending }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
          <p class="text-sm text-gray-600">Rechazadas</p>
          <p class="text-3xl font-bold text-red-600">{{ stats.rejected }}</p>
        </div>
      </div>

      <!-- Lista de Justificaciones -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b">
          <h3 class="text-lg font-semibold text-gray-900">Historial de Justificaciones</h3>
        </div>
        <div class="divide-y divide-gray-200">
          <div v-for="justification in justifications" :key="justification.id"
               class="px-6 py-4 hover:bg-gray-50">
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <div class="flex items-center space-x-3">
                  <p class="font-semibold text-gray-900">{{ justification.course_name }}</p>
                  <span :class="[
                    justification.status === 'approved' ? 'bg-green-100 text-green-800' :
                    justification.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                    'bg-red-100 text-red-800',
                    'px-2 py-1 rounded-full text-xs font-medium'
                  ]">
                    {{ justification.status === 'approved' ? 'Aprobada' : 
                       justification.status === 'pending' ? 'Pendiente' : 'Rechazada' }}
                  </span>
                </div>
                <p class="text-sm text-gray-600 mt-1">
                  Fecha: {{ formatDate(justification.absence_date) }}
                </p>
                <p class="text-sm text-gray-700 mt-2">{{ justification.reason }}</p>
                <div v-if="justification.document_url" class="mt-2">
                  <a :href="justification.document_url" target="_blank" 
                     class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center">
                    📎 Ver documento adjunto
                  </a>
                </div>
                <div v-if="justification.review_notes" class="mt-2 p-3 bg-gray-50 rounded-lg">
                  <p class="text-sm font-medium text-gray-700">Observaciones del revisor:</p>
                  <p class="text-sm text-gray-600 mt-1">{{ justification.review_notes }}</p>
                </div>
              </div>
              <div class="text-sm text-gray-500 text-right">
                <p>{{ formatDate(justification.created_at) }}</p>
                <p class="text-xs mt-1">Revisado por: {{ justification.reviewed_by || 'Pendiente' }}</p>
              </div>
            </div>
          </div>
          <p v-if="justifications.length === 0" class="px-6 py-8 text-center text-gray-500">
            No tienes justificaciones registradas
          </p>
        </div>
      </div>

      <!-- Modal Nueva Justificación -->
      <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
          <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Nueva Justificación</h3>
            <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <div class="px-6 py-4 space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Curso</label>
              <select v-model="form.course_id" class="w-full border-gray-300 rounded-lg">
                <option value="">Seleccionar curso</option>
                <option v-for="course in courses" :key="course.id" :value="course.id">
                  {{ course.name }}
                </option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de la Falta</label>
              <input v-model="form.absence_date" type="date" class="w-full border-gray-300 rounded-lg" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Motivo</label>
              <textarea v-model="form.reason" rows="4" class="w-full border-gray-300 rounded-lg"
                        placeholder="Describe el motivo de tu inasistencia..."></textarea>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Documento de Respaldo</label>
              <input type="file" @change="handleFileUpload" class="w-full border-gray-300 rounded-lg" />
              <p class="text-xs text-gray-500 mt-1">Formatos permitidos: PDF, JPG, PNG (máx. 5MB)</p>
            </div>
          </div>
          <div class="px-6 py-4 border-t flex justify-end space-x-3">
            <button @click="showModal = false" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
              Cancelar
            </button>
            <button @click="submitJustification" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
              Enviar Justificación
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  justifications: {
    type: Array,
    required: true
  },
  stats: {
    type: Object,
    required: true
  },
  courses: {
    type: Array,
    required: true
  }
});

const showModal = ref(false);
const form = ref({
  course_id: '',
  absence_date: '',
  reason: '',
  document: null
});

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-ES', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  });
};

const handleFileUpload = (event) => {
  form.value.document = event.target.files[0];
};

const submitJustification = () => {
  // Implementar envío con Inertia
  router.post('/student/justifications', form.value, {
    onSuccess: () => {
      showModal.value = false;
      form.value = { course_id: '', absence_date: '', reason: '', document: null };
    }
  });
};
</script>
