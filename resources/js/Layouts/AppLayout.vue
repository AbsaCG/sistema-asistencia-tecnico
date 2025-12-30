<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <!-- Logo -->
          <div class="flex items-center">
            <Link href="/dashboard" class="text-2xl font-bold text-indigo-600">
              📚 Control Asistencia
            </Link>
          </div>

          <!-- Nav Links -->
          <div class="flex items-center space-x-8">
            <Link
              href="/dashboard"
              :class="route().current('dashboard') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-gray-900'"
              class="px-1 pt-1 border-b-2 text-sm font-medium"
            >
              Dashboard
            </Link>
            <!-- Admin & Teacher Nav -->
            <template v-if="auth.hasAnyRole(['admin', 'teacher'])">
              <Link
                href="/students"
                :class="route().current('students.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                class="px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Estudiantes
              </Link>
              <Link
                href="/attendance"
                :class="route().current('attendance.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                class="px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Asistencia
              </Link>
              <Link
                href="/reports/attendance"
                :class="route().current('reports.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                class="px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Reportes
              </Link>
            </template>
            <!-- Admin Only Nav -->
            <template v-if="auth.hasRole('admin')">
              <Link
                href="/academic/years"
                :class="route().current('academic.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                class="px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Académico
              </Link>
              <Link
                href="/settings/system"
                :class="route().current('settings.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                class="px-1 pt-1 border-b-2 text-sm font-medium"
              >
                ⚙️ Config
              </Link>
            </template>
          </div>

          <!-- User Menu -->
          <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
              <span class="text-sm text-gray-600">{{ auth.userName }}</span>
              <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded">{{ auth.userRole }}</span>
            </div>
            <form @submit.prevent="logout" method="POST" action="/logout">
              <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                Salir
              </button>
            </form>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <slot />
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { router } from '@inertiajs/inertia-vue3';
import { useAuthStore } from '@/stores/authStore';

const page = usePage();
const auth = useAuthStore();

const logout = () => {
  router.post('/logout');
};
</script>
