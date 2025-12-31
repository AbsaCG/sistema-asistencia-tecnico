<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-600 to-indigo-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
      <!-- Logo -->
      <div class="text-center">
        <h1 class="text-4xl font-bold text-white mb-2">📚</h1>
        <h2 class="text-3xl font-extrabold text-white">Control de Asistencia</h2>
        <p class="mt-2 text-indigo-200">Sistema de gestión educativa</p>
      </div>

      <!-- Login Form -->
      <form @submit.prevent="submit" class="bg-white rounded-lg shadow-xl p-8 space-y-6">
        <div>
          <h3 class="text-2xl font-bold text-gray-900 mb-6">Iniciar sesión</h3>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            autocomplete="email"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="tu@email.com"
          />
          <div v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</div>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            autocomplete="current-password"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="••••••••"
          />
          <div v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</div>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
          <input
            id="remember"
            v-model="form.remember"
            type="checkbox"
            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
          />
          <label for="remember" class="ml-2 block text-sm text-gray-700">Recuérdame</label>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="processing"
          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ processing ? 'Cargando...' : 'Iniciar sesión' }}
        </button>

        <!-- Register Link -->
        <div class="text-center">
          <p class="text-sm text-gray-600">
            ¿No tienes cuenta?
            <Link href="/register" class="font-medium text-indigo-600 hover:text-indigo-500">
              Regístrate aquí
            </Link>
          </p>
        </div>
      </form>

      <!-- Quick Login Buttons -->
      <div class="bg-white rounded-lg shadow-xl p-6">
        <p class="text-sm text-gray-700 font-semibold mb-4 text-center">⚡ Acceso Rápido (Desarrollo)</p>
        <div class="grid grid-cols-1 gap-3">
          <!-- Admin Button -->
          <button
            @click="quickLogin('admin@istp.edu.pe', 'password')"
            :disabled="processing"
            class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg shadow-md transition transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span class="flex items-center">
              <span class="text-lg mr-3">👨‍💼</span>
              <span class="font-medium">Administrador</span>
            </span>
            <span class="text-xs bg-red-800 px-2 py-1 rounded">Admin</span>
          </button>

          <!-- Teacher Button -->
          <button
            @click="quickLogin('profesor@istp.edu.pe', 'password')"
            :disabled="processing"
            class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg shadow-md transition transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span class="flex items-center">
              <span class="text-lg mr-3">👨‍🏫</span>
              <span class="font-medium">Profesor</span>
            </span>
            <span class="text-xs bg-blue-800 px-2 py-1 rounded">Teacher</span>
          </button>

          <!-- Student Button -->
          <button
            @click="quickLogin('estudiante@istp.edu.pe', 'password')"
            :disabled="processing"
            class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg shadow-md transition transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span class="flex items-center">
              <span class="text-lg mr-3">👨‍🎓</span>
              <span class="font-medium">Estudiante</span>
            </span>
            <span class="text-xs bg-green-800 px-2 py-1 rounded">Student</span>
          </button>
        </div>
        <p class="text-xs text-gray-500 text-center mt-4">Contraseña para todos: <code class="bg-gray-100 px-2 py-1 rounded">password</code></p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const processing = ref(false);
const errors = ref({});

const form = ref({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  console.log('Submit clicked with data:', form.value);
  processing.value = true;
  router.post('/login', form.value, {
    onError: (errs) => {
      console.log('Login error:', errs);
      errors.value = errs;
      processing.value = false;
    },
    onSuccess: () => {
      console.log('Login success, redirecting to dashboard');
      processing.value = false;
    },
  });
};

const quickLogin = (email, password) => {
  form.value.email = email;
  form.value.password = password;
  form.value.remember = true;
  
  processing.value = true;
  router.post('/login', form.value, {
    onError: (errs) => {
      console.log('Quick login error:', errs);
      errors.value = errs;
      processing.value = false;
    },
    onSuccess: () => {
      console.log('Quick login success, redirecting to dashboard');
      processing.value = false;
    },
  });
};
</script>
