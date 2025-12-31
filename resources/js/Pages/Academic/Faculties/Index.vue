<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Facultades</h1>
          <p class="mt-2 text-gray-600">Gestión de facultades universitarias</p>
        </div>
        <Link
          href="/academic/faculties/create"
          class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
        >
          + Nueva Facultad
        </Link>
      </div>

      <!-- Faculties Grid -->
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Faculty Card Example -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-500 to-indigo-600">
            <h3 class="text-lg font-bold text-white">Facultad de Ingeniería</h3>
            <p class="text-indigo-100 text-sm">4 Programas</p>
          </div>
          <div class="px-6 py-4">
            <p class="text-gray-700 text-sm mb-4">
              Facultad responsable de programas de ingeniería
            </p>
            <div class="mb-4">
              <p class="text-xs text-gray-500">Decano</p>
              <p class="text-sm font-semibold text-gray-900">Dr. Carlos Rodríguez</p>
              <p class="text-sm text-gray-600">dean.engineering@university.edu</p>
            </div>
            <div class="flex space-x-2">
              <button class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 py-2 px-3 rounded text-sm font-medium">
                Editar
              </button>
              <button class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 py-2 px-3 rounded text-sm font-medium">
                Eliminar
              </button>
            </div>
          </div>
        </div>

        <!-- Faculty Card Example -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-blue-600">
            <h3 class="text-lg font-bold text-white">Facultad de Ciencias</h3>
            <p class="text-blue-100 text-sm">2 Programas</p>
          </div>
          <div class="px-6 py-4">
            <p class="text-gray-700 text-sm mb-4">
              Facultad de ciencias exactas y naturales
            </p>
            <div class="mb-4">
              <p class="text-xs text-gray-500">Decana</p>
              <p class="text-sm font-semibold text-gray-900">Dra. María González</p>
              <p class="text-sm text-gray-600">dean.sciences@university.edu</p>
            </div>
            <div class="flex space-x-2">
              <button class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 py-2 px-3 rounded text-sm font-medium">
                Editar
              </button>
              <button class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 py-2 px-3 rounded text-sm font-medium">
                Eliminar
              </button>
            </div>
          </div>
        </div>

        <!-- Faculty Card Example -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-500 to-green-600">
            <h3 class="text-lg font-bold text-white">Facultad de Administración</h3>
            <p class="text-green-100 text-sm">2 Programas</p>
          </div>
          <div class="px-6 py-4">
            <p class="text-gray-700 text-sm mb-4">
              Facultad de administración y negocios
            </p>
            <div class="mb-4">
              <p class="text-xs text-gray-500">Coordinador</p>
              <p class="text-sm font-semibold text-gray-900">Lic. Roberto Martínez</p>
              <p class="text-sm text-gray-600">dean.business@university.edu</p>
            </div>
            <div class="flex space-x-2">
              <button class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 py-2 px-3 rounded text-sm font-medium">
                Editar
              </button>
              <button class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 py-2 px-3 rounded text-sm font-medium">
                Eliminar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>
