<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold">Horarios por Carrera</h1>
          <p class="text-sm text-gray-600">Lista de horarios programados</p>
        </div>
        <Link href="/academic/schedules/create" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">+ Nuevo Horario</Link>
      </div>

      <div class="bg-white shadow rounded-lg p-4">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Carrera</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Profesor</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Día</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hora</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aula</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="s in schedules.data" :key="s.id">
              <td class="px-4 py-2 text-sm text-gray-700">{{ s.technical_career?.name || '-' }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ s.course?.name || '-' }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ s.teacher?.user?.name || '-' }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ s.day_of_week }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ s.start_time }} - {{ s.end_time }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ s.classroom }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';

const { props } = usePage();
const schedules = props.value.schedules || { data: [] };
</script>
