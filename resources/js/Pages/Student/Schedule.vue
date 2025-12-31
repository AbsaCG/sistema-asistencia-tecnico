<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Mis Horarios</h1>
        <p class="mt-2 text-gray-600">Horario semanal de clases</p>
      </div>

      <!-- Selector de Semana -->
      <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
        <button class="px-4 py-2 text-indigo-600 hover:bg-indigo-50 rounded-lg">
          ← Semana Anterior
        </button>
        <div class="text-center">
          <p class="text-lg font-semibold text-gray-900">Semana Actual</p>
          <p class="text-sm text-gray-600">{{ currentWeek }}</p>
        </div>
        <button class="px-4 py-2 text-indigo-600 hover:bg-indigo-50 rounded-lg">
          Semana Siguiente →
        </button>
      </div>

      <!-- Horario Semanal -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead class="bg-indigo-600 text-white">
              <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Hora</th>
                <th class="px-4 py-3 text-center text-sm font-semibold">Lunes</th>
                <th class="px-4 py-3 text-center text-sm font-semibold">Martes</th>
                <th class="px-4 py-3 text-center text-sm font-semibold">Miércoles</th>
                <th class="px-4 py-3 text-center text-sm font-semibold">Jueves</th>
                <th class="px-4 py-3 text-center text-sm font-semibold">Viernes</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="timeSlot in timeSlots" :key="timeSlot.time" class="hover:bg-gray-50">
                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ timeSlot.time }}
                </td>
                <td v-for="day in ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']" :key="day" class="px-4 py-4">
                  <div v-if="getClassForSlot(day, timeSlot.time)" 
                       :class="[
                         'rounded-lg p-3 text-center',
                         getClassForSlot(day, timeSlot.time).color
                       ]">
                    <p class="font-semibold text-sm">{{ getClassForSlot(day, timeSlot.time).course }}</p>
                    <p class="text-xs mt-1">{{ getClassForSlot(day, timeSlot.time).room }}</p>
                    <p class="text-xs">{{ getClassForSlot(day, timeSlot.time).teacher }}</p>
                  </div>
                  <div v-else class="text-center text-gray-400 text-sm">-</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Próximas Clases -->
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">📚 Próximas Clases de Hoy</h3>
        <div class="space-y-3">
          <div v-for="upcomingClass in upcomingClasses" :key="upcomingClass.id"
               class="flex items-center justify-between border-l-4 border-indigo-500 bg-indigo-50 rounded-lg p-4">
            <div>
              <p class="font-semibold text-gray-900">{{ upcomingClass.course }}</p>
              <p class="text-sm text-gray-600">{{ upcomingClass.teacher }} • {{ upcomingClass.room }}</p>
            </div>
            <div class="text-right">
              <p class="text-lg font-bold text-indigo-600">{{ upcomingClass.time }}</p>
              <p class="text-xs text-gray-500">{{ upcomingClass.duration }} min</p>
            </div>
          </div>
          <p v-if="upcomingClasses.length === 0" class="text-sm text-gray-500 text-center py-4">
            No hay más clases programadas para hoy
          </p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed } from 'vue';

const props = defineProps({
  schedule: {
    type: Object,
    required: true
  },
  upcomingClasses: {
    type: Array,
    default: () => []
  }
});

const timeSlots = [
  { time: '08:00 - 09:30' },
  { time: '09:45 - 11:15' },
  { time: '11:30 - 13:00' },
  { time: '14:00 - 15:30' },
  { time: '15:45 - 17:15' },
  { time: '17:30 - 19:00' }
];

const currentWeek = computed(() => {
  const today = new Date();
  const startOfWeek = new Date(today);
  startOfWeek.setDate(today.getDate() - today.getDay() + 1);
  const endOfWeek = new Date(startOfWeek);
  endOfWeek.setDate(startOfWeek.getDate() + 4);
  
  return `${startOfWeek.toLocaleDateString('es-ES')} - ${endOfWeek.toLocaleDateString('es-ES')}`;
});

const getClassForSlot = (day, time) => {
  return props.schedule[day]?.find(c => c.time === time);
};
</script>
