<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-600 to-blue-800">
    <!-- Login Button (Top Right) -->
    <div class="absolute top-6 right-6">
      <button
        v-if="!showLoginModal"
        @click="showLoginModal = true"
        class="px-6 py-2 bg-white text-indigo-600 font-semibold rounded-lg shadow-lg hover:shadow-xl transition transform hover:scale-105"
      >
        Iniciar Sesión
      </button>
    </div>

    <!-- Login Modal -->
    <div v-if="showLoginModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-2xl w-full max-w-md p-8">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-gray-900">Acceso Administrativo</h2>
          <button
            @click="showLoginModal = false"
            class="text-gray-500 hover:text-gray-700 text-2xl"
          >
            ✕
          </button>
        </div>
        <!-- Quick Login Buttons -->
        <div class="mb-6">
          <p class="text-sm text-gray-700 font-semibold mb-3 text-center">⚡ Acceso Rápido</p>
          <div class="space-y-2">
            <button
              @click="quickLogin('admin@example.com', 'password')"
              :disabled="loggingIn"
              class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg shadow-md transition transform hover:scale-105 disabled:opacity-50"
            >
              <span class="flex items-center">
                <span class="text-lg mr-2">👨‍💼</span>
                <span class="font-medium">Administrador</span>
              </span>
              <span class="text-xs bg-red-800 px-2 py-1 rounded">Admin</span>
            </button>
            
            <button
              @click="quickLogin('ana@example.com', 'password')"
              :disabled="loggingIn"
              class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg shadow-md transition transform hover:scale-105 disabled:opacity-50"
            >
              <span class="flex items-center">
                <span class="text-lg mr-2">👨‍🏫</span>
                <span class="font-medium">Profesor</span>
              </span>
              <span class="text-xs bg-blue-800 px-2 py-1 rounded">Teacher</span>
            </button>
            
            <button
              @click="quickLogin('estudiante@example.com', 'password')"
              :disabled="loggingIn"
              class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg shadow-md transition transform hover:scale-105 disabled:opacity-50"
            >
              <span class="flex items-center">
                <span class="text-lg mr-2">👨‍🎓</span>
                <span class="font-medium">Estudiante</span>
              </span>
              <span class="text-xs bg-green-800 px-2 py-1 rounded">Student</span>
            </button>
          </div>
        </div>

        <div class="relative my-4">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">O ingresa manualmente</span>
          </div>
        </div>

        <form @submit.prevent="handleLogin" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input
              v-model="loginForm.email"
              type="email"
              required
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="admin@example.com"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input
              v-model="loginForm.password"
              type="password"
              required
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              placeholder="••••••••"
            />
          </div>
          <button
            type="submit"
            :disabled="loggingIn"
            class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 disabled:opacity-50"
          >
            {{ loggingIn ? 'Ingresando...' : 'Ingresar' }}
          </button>
          <div v-if="loginError" class="text-red-600 text-sm">{{ loginError }}</div>
        </form>
      </div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-8 sm:p-12">
        <!-- Header -->
        <div class="text-center mb-8">
          <h1 class="text-4xl font-bold text-gray-900 mb-2">🎓 ISTP Control</h1>
          <p class="text-xl text-gray-600">Sistema de Control de Asistencia</p>
          <div class="mt-4 h-1 w-20 bg-gradient-to-r from-indigo-600 to-blue-500 mx-auto rounded-full"></div>
        </div>

        <!-- Student Attendance Form -->
        <div class="space-y-6">
          <div>
            <label class="block text-lg font-semibold text-gray-900 mb-3">
              Ingresa tu DNI para registrar asistencia
            </label>
            <input
              ref="dniInput"
              v-model="studentDni"
              type="text"
              placeholder="Ej: 12345678"
              @keyup.enter="checkAttendance"
              class="w-full px-6 py-3 text-2xl text-center border-2 border-indigo-300 rounded-lg focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition"
              maxlength="8"
              autofocus
            />
            <div v-if="dniError" class="mt-3 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 font-semibold text-sm rounded">
              ❌ {{ dniError }}
            </div>
          </div>

          <button
            @click="checkAttendance"
            :disabled="!studentDni || loading"
            class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold text-lg rounded-lg hover:shadow-lg disabled:opacity-50 transition transform hover:scale-105"
          >
            {{ loading ? '⏳ Verificando...' : '📝 Registrar Asistencia' }}
          </button>
          
          <div class="text-center text-sm text-gray-500 bg-blue-50 p-3 rounded-lg">
            � La información se actualizará con cada nuevo registro
          </div>
        </div>

        <!-- Student Data Display -->
        <div v-if="studentData" class="mt-8 border-t-2 border-green-400 pt-8 animate-fade-in">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-green-600">✅ Último Registro</h2>
            <div class="text-sm text-white bg-green-600 px-4 py-2 rounded-lg font-semibold">
              🔄 Actualizando con cada registro
            </div>
          </div>
          
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-indigo-50 rounded-lg p-4">
              <div class="text-sm text-gray-600">Nombre</div>
              <div class="text-xl font-bold text-gray-900">{{ studentData.name }}</div>
            </div>
            <div class="bg-indigo-50 rounded-lg p-4">
              <div class="text-sm text-gray-600">DNI</div>
              <div class="text-xl font-bold text-gray-900">{{ studentData.dni }}</div>
            </div>
            <div class="bg-indigo-50 rounded-lg p-4">
              <div class="text-sm text-gray-600">Código de Estudiante</div>
              <div class="text-xl font-bold text-gray-900">{{ studentData.student_code }}</div>
            </div>
            <div class="bg-indigo-50 rounded-lg p-4">
              <div class="text-sm text-gray-600">Carrera Técnica</div>
              <div class="text-xl font-bold text-gray-900">{{ studentData.career_name || '—' }}</div>
            </div>
            <div class="bg-indigo-50 rounded-lg p-4">
              <div class="text-sm text-gray-600">Semestre</div>
              <div class="text-xl font-bold text-gray-900">{{ studentData.semester }}</div>
            </div>
            <div class="bg-green-50 rounded-lg p-4 border-2 border-green-300">
              <div class="text-sm text-gray-600">Estado</div>
              <div class="text-xl font-bold text-green-600">✓ Presente</div>
            </div>
          </div>

          <!-- Additional Info -->
          <div class="mt-6 bg-blue-50 rounded-lg p-4">
            <div class="text-sm text-gray-600">Teléfono</div>
            <div class="text-lg font-semibold text-gray-900">{{ studentData.phone || 'No registrado' }}</div>
          </div>
          <div class="mt-4 bg-blue-50 rounded-lg p-4">
            <div class="text-sm text-gray-600">Email</div>
            <div class="text-lg font-semibold text-gray-900">{{ studentData.email || 'No registrado' }}</div>
          </div>

          <div class="mt-6 flex gap-3">
            <button
              @click="resetForm"
              class="flex-1 px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700"
            >
              ← Registrar Otro Estudiante
            </button>
            <button
              @click="downloadReceipt"
              class="flex-1 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700"
            >
              📄 Descargar Comprobante
            </button>
          </div>
        </div>

        <!-- Info Messages -->
        <div v-if="successMessage" class="mt-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
          {{ successMessage }}
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="text-center text-white text-sm py-4">
      <p>© 2025 Instituto Superior Tecnológico - Sistema de Asistencia</p>
    </div>
  </div>
</template>

<script setup>
import { ref, nextTick } from 'vue';
import { router } from '@inertiajs/vue3';

const studentDni = ref('');
const studentData = ref(null);
const loading = ref(false);
const dniError = ref('');
const successMessage = ref('');
const showLoginModal = ref(false);
const loggingIn = ref(false);
const loginError = ref('');
const dniInput = ref(null);

const loginForm = ref({
  email: '',
  password: '',
});

const checkAttendance = async () => {
  dniError.value = '';
  successMessage.value = '';

  if (!studentDni.value || studentDni.value.length < 7) {
    dniError.value = 'Ingresa un DNI válido (mínimo 7 dígitos)';
    return;
  }

  loading.value = true;
  const dniToSearch = studentDni.value; // Guardar el DNI antes de limpiar
  
  // Limpiar el campo DNI inmediatamente para el siguiente
  studentDni.value = '';
  
  // Enfocar el input para el siguiente estudiante
  nextTick(() => {
    dniInput.value?.focus();
  });

  try {
    const response = await fetch('/api/attendance/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: JSON.stringify({
        dni: dniToSearch,
      }),
    });

    const data = await response.json();

    if (response.ok) {
      studentData.value = data.student;
      successMessage.value = `✓ Asistencia registrada a las ${new Date().toLocaleTimeString()}`;
      // Info permanente - se actualizará con el siguiente estudiante
    } else {
      dniError.value = data.message || 'Estudiante no encontrado';
      // Limpiar el error después de 3 segundos
      setTimeout(() => {
        dniError.value = '';
      }, 3000);
    }
  } catch (error) {
    dniError.value = 'Error de conexión. Intenta nuevamente.';
    setTimeout(() => {
      dniError.value = '';
    }, 3000);
  } finally {
    loading.value = false;
  }
};

const resetForm = () => {
  studentDni.value = '';
  studentData.value = null;
  dniError.value = '';
  successMessage.value = '';
};

const handleLogin = () => {
  loggingIn.value = true;
  loginError.value = '';

  router.post('/login', loginForm.value, {
    onSuccess: () => {
      loggingIn.value = false;
      router.visit('/dashboard');
    },
    onError: (errors) => {
      loginError.value = errors.email || 'Email o contraseña incorrectos';
      loggingIn.value = false;
    },
  });
};

const quickLogin = (email, password) => {
  loginForm.value.email = email;
  loginForm.value.password = password;
  loginForm.value.remember = true;
  handleLogin();
};

const downloadReceipt = () => {
  if (!studentData.value) return;
  
  const text = `
COMPROBANTE DE ASISTENCIA
===========================
Nombre: ${studentData.value.name}
DNI: ${studentData.value.dni}
Código: ${studentData.value.student_code}
Carrera: ${studentData.value.career_name || 'N/A'}
Semestre: ${studentData.value.semester}
Fecha: ${new Date().toLocaleDateString()}
Hora: ${new Date().toLocaleTimeString()}
Estado: ✓ PRESENTE
===========================
  `;
  
  const blob = new Blob([text], { type: 'text/plain' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = `asistencia_${studentData.value.dni}_${new Date().toISOString().split('T')[0]}.txt`;
  a.click();
};
</script>
