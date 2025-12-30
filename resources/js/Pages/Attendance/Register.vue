<template>
  <AppLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Registro de Asistencia</h1>
        <p class="mt-2 text-gray-600">Registrar asistencia por clase</p>
      </div>

      <div class="bg-white shadow rounded-lg p-6 space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Grado</label>
            <select v-model="selectedGrade" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">Selecciona grado</option>
              <option value="1">1ro de Primaria</option>
              <option value="2">2do de Primaria</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sección</label>
            <select v-model="selectedSection" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">Selecciona sección</option>
              <option value="A">A</option>
              <option value="B">B</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
            <input
              v-model="selectedDate"
              type="date"
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
        </div>

        <div v-if="selectedGrade && selectedSection" class="space-y-4">
          <h3 class="text-lg font-medium text-gray-900">Estudiantes de {{ selectedGrade }} - {{ selectedSection }}</h3>
          <div class="space-y-2">
            <div v-for="student in studentList" :key="student.id" class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
              <div>
                <p class="text-sm font-medium text-gray-900">{{ student.name }}</p>
                <p class="text-xs text-gray-500">{{ student.code }}</p>
              </div>
              <select
                v-model="attendance[student.id]"
                class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
              >
                <option value="">Selecciona</option>
                <option value="present">Presente</option>
                <option value="absent">Ausente</option>
                <option value="late">Tarde</option>
                <option value="justified">Justificado</option>
              </select>
            </div>
          </div>

          <div class="flex justify-end space-x-3 pt-4 border-t">
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
              Limpiar
            </button>
            <button @click="saveAttendance" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
              Guardar Asistencia
            </button>
          </div>
        </div>

        <div v-else class="text-center py-12 text-gray-500">
          <p>Selecciona grado y sección para continuar</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const selectedGrade = ref('');
const selectedSection = ref('');
const selectedDate = ref(new Date().toISOString().split('T')[0]);
const attendance = ref({});

const studentList = ref([
  { id: 1, code: 'EST001', name: 'Juan Pérez' },
  { id: 2, code: 'EST002', name: 'María García' },
  { id: 3, code: 'EST003', name: 'Carlos López' },
]);

const saveAttendance = () => {
  console.log('Guardando asistencia:', attendance.value);
};
</script>
