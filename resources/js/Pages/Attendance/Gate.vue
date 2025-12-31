<template>
  <AppLayout>
    <div class="max-w-xl mx-auto py-12">
      <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Ingreso - Verificar DNI</h2>
        <form @submit.prevent="lookup" class="space-y-4">
          <input v-model="dni" type="text" placeholder="DNI del estudiante" class="w-full px-3 py-2 border rounded" />
          <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Buscar</button>
            <button type="button" @click="clear" class="px-4 py-2 bg-gray-100 rounded">Limpiar</button>
          </div>
        </form>

        <div v-if="loading" class="mt-4 text-sm text-gray-500">Buscando...</div>

        <div v-if="error" class="mt-4 text-sm text-red-600">{{ error }}</div>

        <div v-if="student" class="mt-6 border-t pt-4">
          <h3 class="text-lg font-medium">Datos del Estudiante</h3>
          <ul class="mt-2 space-y-1 text-sm text-gray-700">
            <li><strong>Código:</strong> {{ student.student_code || '-' }}</li>
            <li><strong>Nombre:</strong> {{ student.name || 'Sin nombre' }}</li>
            <li><strong>DNI:</strong> {{ student.dni }}</li>
            <li><strong>Carrera:</strong> {{ student.career?.name || 'Sin carrera' }}</li>
            <li><strong>Semestre:</strong> {{ student.semester || '-' }}</li>
            <li><strong>Teléfono:</strong> {{ student.phone || '-' }}</li>
            <li><strong>Email:</strong> {{ student.email || '-' }}</li>
          </ul>
          <div class="mt-4">
            <button @click="register" class="px-4 py-2 bg-green-600 text-white rounded">Registrar</button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';

const dni = ref('');
const student = ref(null);
const loading = ref(false);
const error = ref('');

const lookup = async () => {
  error.value = '';
  student.value = null;
  if (!dni.value) { error.value = 'Ingresa DNI'; return; }
  loading.value = true;
  try {
    const res = await fetch('/attendance/gate/check', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
      body: JSON.stringify({ dni: dni.value })
    });
    if (res.status === 200) {
      student.value = await res.json();
    } else if (res.status === 404) {
      const j = await res.json();
      error.value = j.message || 'No encontrado';
    } else {
      error.value = 'Error del servidor';
    }
  } catch (e) {
    error.value = 'Error de conexión';
  } finally {
    loading.value = false;
  }
};

const register = async () => {
  if (!student.value) return;
  loading.value = true;
  error.value = '';
  try {
    const res = await fetch('/attendance/gate/check', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
      body: JSON.stringify({ dni: dni.value, register: true })
    });
    if (res.status === 200) {
      // remain showing student; consider showing toast
    } else {
      const j = await res.json();
      error.value = j.message || 'Error al registrar';
    }
  } catch (e) {
    error.value = 'Error de conexión';
  } finally {
    loading.value = false;
  }
};

const clear = () => { dni.value = ''; student.value = null; error.value = ''; };
</script>
