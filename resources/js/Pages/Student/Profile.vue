<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Mi Perfil</h1>
        <p class="mt-2 text-gray-600">Información personal y académica</p>
      </div>

      <!-- Perfil del Estudiante -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-8">
          <div class="flex items-center space-x-4">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-3xl font-bold text-indigo-600">
              {{ student.initials }}
            </div>
            <div class="text-white">
              <h2 class="text-2xl font-bold">{{ student.full_name }}</h2>
              <p class="text-indigo-100">{{ student.email }}</p>
              <p class="text-sm text-indigo-200 mt-1">{{ student.program_name }}</p>
            </div>
          </div>
        </div>

        <div class="px-6 py-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información Personal -->
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Personal</h3>
              <dl class="space-y-3">
                <div>
                  <dt class="text-sm font-medium text-gray-500">DNI</dt>
                  <dd class="text-sm text-gray-900">{{ student.dni }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                  <dd class="text-sm text-gray-900">{{ student.birth_date || 'No registrado' }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                  <dd class="text-sm text-gray-900">{{ student.phone || 'No registrado' }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                  <dd class="text-sm text-gray-900">{{ student.address || 'No registrado' }}</dd>
                </div>
              </dl>
            </div>

            <!-- Información Académica -->
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Académica</h3>
              <dl class="space-y-3">
                <div>
                  <dt class="text-sm font-medium text-gray-500">Carrera</dt>
                  <dd class="text-sm text-gray-900">{{ student.program_name }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Facultad</dt>
                  <dd class="text-sm text-gray-900">{{ student.faculty_name }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Código de Estudiante</dt>
                  <dd class="text-sm text-gray-900">{{ student.code }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Estado</dt>
                  <dd class="text-sm">
                    <span :class="[student.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800', 'px-2 py-1 rounded-full text-xs font-medium']">
                      {{ student.status === 'active' ? 'Activo' : 'Inactivo' }}
                    </span>
                  </dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Fecha de Ingreso</dt>
                  <dd class="text-sm text-gray-900">{{ student.enrollment_date }}</dd>
                </div>
              </dl>
            </div>
          </div>

          <!-- Estadísticas Rápidas -->
          <div class="mt-8 pt-6 border-t">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas del Período Actual</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div class="bg-green-50 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-green-600">{{ stats.attendance_percentage }}%</div>
                <div class="text-sm text-gray-600 mt-1">Asistencia</div>
              </div>
              <div class="bg-blue-50 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-blue-600">{{ stats.total_classes }}</div>
                <div class="text-sm text-gray-600 mt-1">Clases Totales</div>
              </div>
              <div class="bg-purple-50 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-purple-600">{{ stats.absences }}</div>
                <div class="text-sm text-gray-600 mt-1">Faltas</div>
              </div>
            </div>
          </div>

          <!-- Botón de edición (futuro) -->
          <div class="mt-6 flex justify-end">
            <button disabled class="px-4 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed">
              Editar Perfil (Próximamente)
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  student: {
    type: Object,
    required: true
  },
  stats: {
    type: Object,
    required: true
  }
});
</script>
