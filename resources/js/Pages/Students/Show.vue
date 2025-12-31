<template>
  <AppLayout title="Ver Estudiante">
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- Header -->
          <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-full bg-blue-500 text-white flex items-center justify-center text-xl font-bold">
                  {{ student.initials }}
                </div>
                <div>
                  <h2 class="text-2xl font-bold text-gray-900">{{ student.name }}</h2>
                  <p class="text-sm text-gray-500">{{ student.code }}</p>
                </div>
              </div>
              <div class="flex space-x-2">
                <Link 
                  :href="`/students/${student.id}/edit`"
                  class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition"
                >
                  ✏️ Editar
                </Link>
                <Link 
                  href="/students"
                  class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
                >
                  ← Volver
                </Link>
              </div>
            </div>
          </div>

          <!-- Información del estudiante -->
          <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Información Personal -->
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Información Personal</h3>
                <div class="space-y-3">
                  <div>
                    <p class="text-sm text-gray-500">DNI</p>
                    <p class="text-base font-medium text-gray-900">{{ student.dni }}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-base font-medium text-gray-900">{{ student.email }}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Teléfono</p>
                    <p class="text-base font-medium text-gray-900">{{ student.phone }}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Dirección</p>
                    <p class="text-base font-medium text-gray-900">{{ student.address }}</p>
                  </div>
                </div>
              </div>

              <!-- Información Académica -->
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">🎓 Información Académica</h3>
                <div class="space-y-3">
                  <div>
                    <p class="text-sm text-gray-500">Código de Estudiante</p>
                    <p class="text-base font-medium text-gray-900">{{ student.code }}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Carrera Técnica</p>
                    <p class="text-base font-medium text-gray-900">{{ student.career }}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Estado</p>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                      {{ student.status === 'active' ? 'Activo' : 'Inactivo' }}
                    </span>
                  </div>
                </div>
              </div>
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

defineProps({
  student: Object
});
</script>
