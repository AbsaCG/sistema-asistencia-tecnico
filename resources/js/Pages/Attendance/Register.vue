<template>
  <AppLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Registro de Asistencia</h1>
        <p class="mt-2 text-gray-600">Registrar asistencia por clase</p>
      </div>

      <!-- Mensaje de éxito -->
      <div v-if="$page.props.flash?.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        {{ $page.props.flash.success }}
      </div>

      <div class="bg-white shadow rounded-lg p-6 space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">🎓 Carrera Técnica</label>
            <select v-model="selectedCareer" @change="loadStudents" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">Selecciona carrera</option>
              <option v-for="career in careers" :key="career.id" :value="career.id">
                {{ career.name }}
              </option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📊 Ciclo</label>
            <select v-model="selectedSemester" @change="loadStudents" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">Selecciona ciclo</option>
              <option value="1">I Ciclo</option>
              <option value="2">II Ciclo</option>
              <option value="3">III Ciclo</option>
              <option value="4">IV Ciclo</option>
              <option value="5">V Ciclo</option>
              <option value="6">VI Ciclo</option>
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

        <!-- Loading -->
        <div v-if="loading" class="text-center py-12 text-gray-500">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto mb-4"></div>
          <p>Cargando estudiantes...</p>
        </div>

        <!-- Lista de estudiantes -->
        <div v-else-if="selectedCareer && selectedSemester && studentList.length > 0" class="space-y-4">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Estudiantes ({{ studentList.length }})</h3>
            <div class="space-x-2">
              <button @click="markAll('present')" class="text-xs px-3 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200">
                ✓ Todos Presentes
              </button>
              <button @click="markAll('absent')" class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">
                ✗ Todos Ausentes
              </button>
            </div>
          </div>
          
          <div class="max-h-96 overflow-y-auto space-y-2">
            <div v-for="student in studentList" :key="student.id" class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">{{ student.name }}</p>
                <p class="text-xs text-gray-500">DNI: {{ student.dni }} | Código: {{ student.code }}</p>
              </div>
              <div class="flex items-center space-x-2">
                <button
                  @click="attendance[student.id] = 'present'"
                  :class="[
                    'px-3 py-1 text-xs font-medium rounded',
                    attendance[student.id] === 'present'
                      ? 'bg-green-600 text-white'
                      : 'bg-gray-100 text-gray-700 hover:bg-green-100'
                  ]"
                >
                  ✓ Presente
                </button>
                <button
                  @click="attendance[student.id] = 'late'"
                  :class="[
                    'px-3 py-1 text-xs font-medium rounded',
                    attendance[student.id] === 'late'
                      ? 'bg-yellow-600 text-white'
                      : 'bg-gray-100 text-gray-700 hover:bg-yellow-100'
                  ]"
                >
                  ⏰ Tarde
                </button>
                <button
                  @click="attendance[student.id] = 'absent'"
                  :class="[
                    'px-3 py-1 text-xs font-medium rounded',
                    attendance[student.id] === 'absent'
                      ? 'bg-red-600 text-white'
                      : 'bg-gray-100 text-gray-700 hover:bg-red-100'
                  ]"
                >
                  ✗ Ausente
                </button>
              </div>
            </div>
          </div>

          <div class="flex justify-end space-x-3 pt-4 border-t">
            <button @click="clearAttendance" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
              Limpiar
            </button>
            <button @click="saveAttendance" :disabled="saving" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50">
              <span v-if="saving">Guardando...</span>
              <span v-else>Guardar Asistencia</span>
            </button>
          </div>
        </div>

        <!-- No hay estudiantes -->
        <div v-else-if="selectedCareer && selectedSemester && studentList.length === 0 && !loading" class="text-center py-12 text-gray-500">
          <p>No hay estudiantes en esta carrera y ciclo</p>
        </div>

        <!-- Sin selección -->
        <div v-else class="text-center py-12 text-gray-500">
          <p>Selecciona carrera y ciclo para continuar</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

const props = defineProps({
  careers: {
    type: Array,
    default: () => [],
  },
});

const selectedCareer = ref('');
const selectedSemester = ref('');
const selectedDate = ref(new Date().toISOString().split('T')[0]);
const attendance = ref({});
const studentList = ref([]);
const loading = ref(false);
const saving = ref(false);

const loadStudents = async () => {
  if (!selectedCareer.value || !selectedSemester.value) {
    studentList.value = [];
    return;
  }

  loading.value = true;
  try {
    const response = await axios.get('/api/students', {
      params: {
        career_id: selectedCareer.value,
        semester: selectedSemester.value,
      },
    });
    
    studentList.value = response.data.students || [];
    attendance.value = {};
  } catch (error) {
    console.error('Error al cargar estudiantes:', error);
    studentList.value = [];
  } finally {
    loading.value = false;
  }
};

const markAll = (status) => {
  studentList.value.forEach(student => {
    attendance.value[student.id] = status;
  });
};

const clearAttendance = () => {
  attendance.value = {};
};

const saveAttendance = () => {
  const attendanceList = Object.entries(attendance.value)
    .filter(([_, status]) => status) // Solo incluir los que tienen status
    .map(([studentId, status]) => ({
      student_id: parseInt(studentId),
      status: status,
    }));

  if (attendanceList.length === 0) {
    alert('Por favor marca la asistencia de al menos un estudiante');
    return;
  }

  saving.value = true;

  router.post('/attendance/register', {
    career_id: selectedCareer.value,
    semester: parseInt(selectedSemester.value),
    date: selectedDate.value,
    attendances: attendanceList,
  }, {
    onSuccess: () => {
      attendance.value = {};
      saving.value = false;
    },
    onError: (errors) => {
      console.error('Error al guardar:', errors);
      alert('Error al guardar la asistencia');
      saving.value = false;
    },
  });
};
</script>
