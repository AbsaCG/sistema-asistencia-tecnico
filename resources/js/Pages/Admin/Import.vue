<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div>
        <h1 class="text-3xl font-bold text-gray-900">📥 Importación Masiva de Estudiantes</h1>
        <p class="mt-2 text-gray-600">Carga hasta 2000 estudiantes desde un archivo Excel o CSV</p>
      </div>

      <!-- Advertencia -->
      <div v-if="!studentRoleExists" class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex">
          <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
          </svg>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">Error: Rol "student" no existe</h3>
            <p class="mt-1 text-sm text-red-700">Debe crear el rol "student" antes de importar estudiantes.</p>
          </div>
        </div>
      </div>

      <!-- Instrucciones -->
      <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h2 class="text-lg font-semibold text-blue-900 mb-3">📋 Instrucciones</h2>
        <ol class="list-decimal list-inside space-y-2 text-blue-800">
          <li>Descarga la plantilla de Excel haciendo clic en el botón de abajo</li>
          <li>Completa la plantilla con los datos de los estudiantes (DNI, Nombre, Email, Código)</li>
          <li>Selecciona la carrera técnica para todos los estudiantes del archivo</li>
          <li>Sube el archivo completado</li>
          <li>El sistema creará automáticamente:
            <ul class="list-disc list-inside ml-6 mt-1 space-y-1">
              <li>Usuario con email y contraseña = DNI</li>
              <li>Perfil de estudiante vinculado</li>
              <li>Asignación a la carrera seleccionada</li>
            </ul>
          </li>
        </ol>
      </div>

      <!-- Descargar Plantilla -->
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">1️⃣ Descargar Plantilla</h3>
        <a :href="route('import.template')" 
           class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
          </svg>
          Descargar Plantilla CSV
        </a>
        <p class="mt-2 text-sm text-gray-600">
          💡 La plantilla incluye ejemplos de cómo debe estructurarse la información
        </p>
      </div>

      <!-- Formulario de Importación -->
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">2️⃣ Subir Archivo</h3>
        
        <form @submit.prevent="submitImport" class="space-y-4">
          <!-- Seleccionar Carrera -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              🎓 Carrera Técnica <span class="text-red-500">*</span>
            </label>
            <select
              v-model="form.career_id"
              required
              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Seleccione una carrera</option>
              <option v-for="career in careers" :key="career.id" :value="career.id">
                {{ career.name }} ({{ career.code }})
              </option>
            </select>
            <p class="mt-1 text-sm text-gray-500">
              Todos los estudiantes del archivo serán asignados a esta carrera
            </p>
          </div>

          <!-- Seleccionar Archivo -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              📄 Archivo Excel/CSV <span class="text-red-500">*</span>
            </label>
            <input
              type="file"
              @change="handleFileChange"
              accept=".xlsx,.xls,.csv"
              required
              class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0
                file:text-sm file:font-semibold
                file:bg-indigo-50 file:text-indigo-700
                hover:file:bg-indigo-100
                cursor-pointer"
            />
            <p class="mt-1 text-sm text-gray-500">
              Formatos aceptados: .xlsx, .xls, .csv (Máximo 10 MB)
            </p>
          </div>

          <!-- Archivo Seleccionado -->
          <div v-if="form.file" class="bg-gray-50 p-3 rounded-md">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium text-gray-900">{{ form.file.name }}</span>
                <span class="ml-2 text-xs text-gray-500">({{ formatFileSize(form.file.size) }})</span>
              </div>
              <button
                type="button"
                @click="removeFile"
                class="text-red-600 hover:text-red-800"
              >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
              </button>
            </div>
          </div>

          <!-- Botón de Importar -->
          <div class="flex space-x-3">
            <button
              type="submit"
              :disabled="processing || !form.career_id || !form.file"
              class="flex-1 flex justify-center items-center px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg v-if="processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ processing ? 'Importando...' : '📥 Importar Estudiantes' }}
            </button>
          </div>
        </form>
      </div>

      <!-- Información Adicional -->
      <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
          <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
          </svg>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-yellow-800">Notas Importantes</h3>
            <div class="mt-2 text-sm text-yellow-700 space-y-1">
              <p>• La contraseña por defecto será el DNI del estudiante</p>
              <p>• Si el email está vacío, se generará: DNI@istp.edu.pe</p>
              <p>• Los estudiantes duplicados (mismo DNI o email) serán omitidos</p>
              <p>• El proceso puede tardar varios minutos para archivos grandes</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  careers: Array,
  studentRoleExists: Boolean,
});

const form = ref({
  career_id: '',
  file: null,
});

const processing = ref(false);

const handleFileChange = (event) => {
  form.value.file = event.target.files[0];
};

const removeFile = () => {
  form.value.file = null;
};

const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
};

const submitImport = () => {
  if (!form.value.file || !form.value.career_id) return;

  processing.value = true;

  const formData = new FormData();
  formData.append('file', form.value.file);
  formData.append('career_id', form.value.career_id);

  router.post(route('import.students'), formData, {
    onSuccess: () => {
      form.value = { career_id: '', file: null };
      processing.value = false;
    },
    onError: () => {
      processing.value = false;
    },
  });
};
</script>
