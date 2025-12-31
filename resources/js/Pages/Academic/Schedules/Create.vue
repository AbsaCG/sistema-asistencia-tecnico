<template>
  <AppLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-2xl font-bold">Crear Horario</h1>
        <p class="text-sm text-gray-600">Agregar un nuevo bloque horario para una carrera</p>
      </div>

      <div class="bg-white shadow rounded-lg p-6">
        <form @submit.prevent="submit" class="grid grid-cols-1 gap-4">
          <select v-model="form.technical_career_id" class="px-3 py-2 border">
            <option value="">Selecciona Carrera</option>
            <option v-for="c in careers" :key="c.id" :value="c.id">{{ c.name }}</option>
          </select>
          <input v-model="form.course_id" placeholder="ID Curso" class="px-3 py-2 border" />
          <input v-model="form.teacher_id" placeholder="ID Profesor" class="px-3 py-2 border" />
          <select v-model="form.day_of_week" class="px-3 py-2 border">
            <option value="lunes">Lunes</option>
            <option value="martes">Martes</option>
            <option value="miércoles">Miércoles</option>
            <option value="jueves">Jueves</option>
            <option value="viernes">Viernes</option>
          </select>
          <div class="flex gap-2"><input v-model="form.start_time" type="time" class="px-3 py-2 border"/><input v-model="form.end_time" type="time" class="px-3 py-2 border"/></div>
          <input v-model="form.classroom" placeholder="Aula" class="px-3 py-2 border" />
          <div class="flex justify-end"><button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Guardar</button></div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const { props } = usePage();
const careers = props.value.careers || [];

const form = ref({ technical_career_id: '', course_id: '', teacher_id: '', day_of_week: 'lunes', start_time: '', end_time: '', classroom: '' });

const submit = () => {
  // simple post via form submit (Implements later with Inertia.post)
  const fd = new FormData();
  Object.keys(form.value).forEach(k => fd.append(k, form.value[k]));
  fetch('/academic/schedules', { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(() => location.href = '/academic/schedules');
};
</script>
