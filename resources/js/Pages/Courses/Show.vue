<template>
  <AppLayout title="Ver Unidad Didáctica">
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- Header -->
          <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ course.name }}</h2>
                <p class="text-sm text-gray-500">{{ course.code }}</p>
              </div>
              <div class="flex space-x-2">
                <Link 
                  :href="`/courses/${course.id}/edit`"
                  class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition"
                >
                  ✏️ Editar
                </Link>
                <Link 
                  href="/courses"
                  class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
                >
                  ← Volver
                </Link>
              </div>
            </div>
          </div>

          <!-- Información del curso -->
          <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Información Básica -->
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📚 Información Básica</h3>
                <div class="space-y-3">
                  <div>
                    <p class="text-sm text-gray-500">Código</p>
                    <p class="text-base font-medium text-gray-900">{{ course.code }}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Nombre de la Unidad</p>
                    <p class="text-base font-medium text-gray-900">{{ course.name }}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Descripción</p>
                    <p class="text-base text-gray-900">{{ course.description }}</p>
                  </div>
                </div>
              </div>

              <!-- Información Académica -->
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">🎓 Información Académica</h3>
                <div class="space-y-3">
                  <div>
                    <p class="text-sm text-gray-500">Carrera Técnica</p>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                      {{ course.career }}
                    </span>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Ciclo</p>
                    <p class="text-base font-medium text-gray-900">{{ course.cycle }}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Créditos</p>
                    <p class="text-base font-medium text-gray-900">{{ course.credits }} créditos</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Horas por Semana</p>
                    <p class="text-base font-medium text-gray-900">{{ course.hours }} horas/semana</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Estado</p>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                      {{ course.status === 'active' ? 'Activo' : 'Inactivo' }}
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
  course: Object
});
</script>
