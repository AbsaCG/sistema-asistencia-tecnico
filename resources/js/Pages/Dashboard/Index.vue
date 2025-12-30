<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="mt-2 text-gray-600">Bienvenido al Sistema de Control de Asistencia</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Estudiantes -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <span class="text-3xl">👥</span>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Estudiantes</dt>
                  <dd class="text-lg font-medium text-gray-900">1,250</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <!-- Asistencia Hoy -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <span class="text-3xl">✅</span>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Presente Hoy</dt>
                  <dd class="text-lg font-medium text-green-600">1,089 (87%)</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <!-- Ausencias Hoy -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <span class="text-3xl">❌</span>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Ausente Hoy</dt>
                  <dd class="text-lg font-medium text-red-600">161 (13%)</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <!-- Docentes Activos -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <span class="text-3xl">👨‍🏫</span>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Docentes Activos</dt>
                  <dd class="text-lg font-medium text-gray-900">85</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Acciones Rápidas -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Acciones Rápidas</h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <Link
              href="/attendance/register"
              class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
            >
              Registrar Asistencia
            </Link>
            <Link
              href="/students"
              class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
            >
              Ver Estudiantes
            </Link>
            <Link
              href="/reports/attendance"
              class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
            >
              Ver Reportes
            </Link>
            <Link
              href="/settings/system"
              class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
            >
              Configuración
            </Link>
          </div>
        </div>
      </div>

      <!-- Actividad Reciente -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Actividad Reciente</h3>
          <div class="space-y-4">
            <div class="flex items-center">
              <div class="w-2 h-2 bg-indigo-600 rounded-full"></div>
              <span class="ml-3 text-sm text-gray-600">Se registró asistencia para 45 estudiantes</span>
              <span class="ml-auto text-sm text-gray-500">Hace 2 horas</span>
            </div>
            <div class="flex items-center">
              <div class="w-2 h-2 bg-green-600 rounded-full"></div>
              <span class="ml-3 text-sm text-gray-600">Se creó nuevo período académico</span>
              <span class="ml-auto text-sm text-gray-500">Ayer</span>
            </div>
            <div class="flex items-center">
              <div class="w-2 h-2 bg-yellow-600 rounded-full"></div>
              <span class="ml-3 text-sm text-gray-600">Se importaron 5 estudiantes</span>
              <span class="ml-auto text-sm text-gray-500">Hace 3 días</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>
