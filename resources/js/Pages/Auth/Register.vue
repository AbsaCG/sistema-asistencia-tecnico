<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-600 to-indigo-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
      <!-- Logo -->
      <div class="text-center">
        <h1 class="text-4xl font-bold text-white mb-2">📚</h1>
        <h2 class="text-3xl font-extrabold text-white">Control de Asistencia</h2>
        <p class="mt-2 text-indigo-200">Sistema de gestión educativa</p>
      </div>

      <!-- Register Form -->
      <form @submit.prevent="submit" class="bg-white rounded-lg shadow-xl p-8 space-y-6">
        <div>
          <h3 class="text-2xl font-bold text-gray-900 mb-6">Crear cuenta</h3>
        </div>

        <!-- Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            autocomplete="name"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="Juan Pérez"
          />
          <div v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</div>
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
            autocomplete="new-password"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="••••••••"
          />
          <div v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</div>
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
          <input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            autocomplete="new-password"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="••••••••"
          />
          <div v-if="errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ errors.password_confirmation }}</div>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="processing"
          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ processing ? 'Cargando...' : 'Crear cuenta' }}
        </button>

        <!-- Login Link -->
        <div class="text-center">
          <p class="text-sm text-gray-600">
            ¿Ya tienes cuenta?
            <Link href="/login" class="font-medium text-indigo-600 hover:text-indigo-500">
              Inicia sesión aquí
            </Link>
          </p>
        </div>
      </form>
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
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  console.log('Register clicked with data:', form.value);
  processing.value = true;
  router.post('/register', form.value, {
    onError: (errs) => {
      console.log('Register error:', errs);
      errors.value = errs;
      processing.value = false;
    },
    onSuccess: () => {
      console.log('Register success, redirecting to dashboard');
      processing.value = false;
    },
  });
};
</script>
