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

      <!-- Demo Credentials -->
      <div class="bg-indigo-100 border border-indigo-300 rounded-lg p-4">
        <p class="text-sm text-indigo-900 font-medium mb-2">Credenciales de Prueba:</p>
        <p class="text-xs text-indigo-800">Email: <code class="bg-indigo-50 px-1">admin@example.com</code></p>
        <p class="text-xs text-indigo-800">Contraseña: <code class="bg-indigo-50 px-1">password</code></p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';

const page = usePage();
const processing = ref(false);

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const errors = ref({});

const submit = async () => {
  processing.value = true;
  try {
    await form.post('/login', {
      onError: (errs) => {
        errors.value = errs;
      },
    });
  } finally {
    processing.value = false;
  }
};
</script>
