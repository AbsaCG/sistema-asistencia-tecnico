<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Carreras Técnicas</h1>
          <p class="mt-2 text-gray-600">Gestión de programas académicos del instituto</p>
        </div>
        <button
          v-if="canManage"
          class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2"
        >
          <span>+ Nueva Carrera</span>
        </button>
      </div>

      <!-- Filter and Search -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Carrera</label>
            <input
              type="text"
              placeholder="Producción Agropecuaria, Contabilidad..."
              class="w-full rounded-lg border-gray-300 shadow-sm"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
            <select class="w-full rounded-lg border-gray-300 shadow-sm">
              <option value="">Todas</option>
              <option value="activas">Activas</option>
              <option value="inactivas">Inactivas</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Careers Grid -->
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Carrera 1 -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition">
          <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600">
            <h3 class="text-lg font-bold text-white">Producción Agropecuaria</h3>
            <p class="text-green-100 text-sm">Código: PA-2024</p>
          </div>
          <div class="px-6 py-4">
            <p class="text-gray-600 text-sm mb-4">
              Técnico superior en producción y gestión agropecuaria
            </p>
            <div class="space-y-2 mb-4 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-500">Semestres:</span>
                <span class="font-semibold text-gray-900">4</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Créditos:</span>
                <span class="font-semibold text-gray-900">120</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Matricula:</span>
                <span class="font-semibold text-gray-900">S/. 450</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Estudiantes:</span>
                <span class="font-semibold text-gray-900">42</span>
              </div>
            </div>
            <div class="border-t pt-3">
              <p class="text-xs text-gray-500 mb-1">Coordinador</p>
              <p class="text-sm font-semibold text-gray-900">Ing. Juan Rojas</p>
              <p class="text-xs text-gray-600">juan.rojas@istp.edu.pe</p>
            </div>
            <div class="mt-4 flex space-x-2">
              <button class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 py-2 px-3 rounded text-sm font-medium">
                Editar
              </button>
              <button class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 py-2 px-3 rounded text-sm font-medium">
                Ver
              </button>
            </div>
          </div>
        </div>

        <!-- Carrera 2 -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition">
          <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600">
            <h3 class="text-lg font-bold text-white">Contabilidad</h3>
            <p class="text-purple-100 text-sm">Código: CONT-2024</p>
          </div>
          <div class="px-6 py-4">
            <p class="text-gray-600 text-sm mb-4">
              Técnico superior en contabilidad y gestión contable
            </p>
            <div class="space-y-2 mb-4 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-500">Semestres:</span>
                <span class="font-semibold text-gray-900">4</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Créditos:</span>
                <span class="font-semibold text-gray-900">120</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Matricula:</span>
                <span class="font-semibold text-gray-900">S/. 400</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Estudiantes:</span>
                <span class="font-semibold text-gray-900">58</span>
              </div>
            </div>
            <div class="border-t pt-3">
              <p class="text-xs text-gray-500 mb-1">Coordinadora</p>
              <p class="text-sm font-semibold text-gray-900">CPC. María García</p>
              <p class="text-xs text-gray-600">maria.garcia@istp.edu.pe</p>
            </div>
            <div class="mt-4 flex space-x-2">
              <button class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 py-2 px-3 rounded text-sm font-medium">
                Editar
              </button>
              <button class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 py-2 px-3 rounded text-sm font-medium">
                Ver
              </button>
            </div>
          </div>
        </div>

        <!-- Carrera 3 -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition">
          <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
            <h3 class="text-lg font-bold text-white">Desarrollo de Software</h3>
            <p class="text-blue-100 text-sm">Código: DEVSW-2024</p>
          </div>
          <div class="px-6 py-4">
            <p class="text-gray-600 text-sm mb-4">
              Técnico superior en desarrollo de aplicaciones web y móviles
            </p>
            <div class="space-y-2 mb-4 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-500">Semestres:</span>
                <span class="font-semibold text-gray-900">4</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Créditos:</span>
                <span class="font-semibold text-gray-900">120</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Matricula:</span>
                <span class="font-semibold text-gray-900">S/. 500</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Estudiantes:</span>
                <span class="font-semibold text-gray-900">65</span>
              </div>
            </div>
            <div class="border-t pt-3">
              <p class="text-xs text-gray-500 mb-1">Coordinador</p>
              <p class="text-sm font-semibold text-gray-900">Ing. Roberto Silva</p>
              <p class="text-xs text-gray-600">roberto.silva@istp.edu.pe</p>
            </div>
            <div class="mt-4 flex space-x-2">
              <button class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 py-2 px-3 rounded text-sm font-medium">
                Editar
              </button>
              <button class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 py-2 px-3 rounded text-sm font-medium">
                Ver
              </button>
            </div>
          </div>
        </div>

        <!-- Carrera 4 -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition">
          <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-red-600">
            <h3 class="text-lg font-bold text-white">Administración de Empresas</h3>
            <p class="text-red-100 text-sm">Código: ADM-2024</p>
          </div>
          <div class="px-6 py-4">
            <p class="text-gray-600 text-sm mb-4">
              Técnico superior en administración y gestión empresarial
            </p>
            <div class="space-y-2 mb-4 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-500">Semestres:</span>
                <span class="font-semibold text-gray-900">4</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Créditos:</span>
                <span class="font-semibold text-gray-900">120</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Matricula:</span>
                <span class="font-semibold text-gray-900">S/. 400</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Estudiantes:</span>
                <span class="font-semibold text-gray-900">52</span>
              </div>
            </div>
            <div class="border-t pt-3">
              <p class="text-xs text-gray-500 mb-1">Coordinador</p>
              <p class="text-sm font-semibold text-gray-900">Lic. Pedro López</p>
              <p class="text-xs text-gray-600">pedro.lopez@istp.edu.pe</p>
            </div>
            <div class="mt-4 flex space-x-2">
              <button class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 py-2 px-3 rounded text-sm font-medium">
                Editar
              </button>
              <button class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 py-2 px-3 rounded text-sm font-medium">
                Ver
              </button>
            </div>
          </div>
        </div>

        <!-- Carrera 5 -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition">
          <div class="px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600">
            <h3 class="text-lg font-bold text-white">Gastronomía</h3>
            <p class="text-yellow-100 text-sm">Código: GAST-2024</p>
          </div>
          <div class="px-6 py-4">
            <p class="text-gray-600 text-sm mb-4">
              Técnico en cocina y artes culinarias
            </p>
            <div class="space-y-2 mb-4 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-500">Semestres:</span>
                <span class="font-semibold text-gray-900">4</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Créditos:</span>
                <span class="font-semibold text-gray-900">120</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Matricula:</span>
                <span class="font-semibold text-gray-900">S/. 480</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Estudiantes:</span>
                <span class="font-semibold text-gray-900">38</span>
              </div>
            </div>
            <div class="border-t pt-3">
              <p class="text-xs text-gray-500 mb-1">Coordinador</p>
              <p class="text-sm font-semibold text-gray-900">Chef. Francisco Díaz</p>
              <p class="text-xs text-gray-600">francisco.diaz@istp.edu.pe</p>
            </div>
            <div class="mt-4 flex space-x-2">
              <button class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 py-2 px-3 rounded text-sm font-medium">
                Editar
              </button>
              <button class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 py-2 px-3 rounded text-sm font-medium">
                Ver
              </button>
            </div>
          </div>
        </div>

        <!-- Carrera 6 -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition">
          <div class="px-6 py-4 bg-gradient-to-r from-pink-500 to-pink-600">
            <h3 class="text-lg font-bold text-white">Enfermería Técnica</h3>
            <p class="text-pink-100 text-sm">Código: ENFER-2024</p>
          </div>
          <div class="px-6 py-4">
            <p class="text-gray-600 text-sm mb-4">
              Técnico superior en enfermería y cuidados de salud
            </p>
            <div class="space-y-2 mb-4 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-500">Semestres:</span>
                <span class="font-semibold text-gray-900">4</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Créditos:</span>
                <span class="font-semibold text-gray-900">120</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Matricula:</span>
                <span class="font-semibold text-gray-900">S/. 520</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Estudiantes:</span>
                <span class="font-semibold text-gray-900">45</span>
              </div>
            </div>
            <div class="border-t pt-3">
              <p class="text-xs text-gray-500 mb-1">Coordinadora</p>
              <p class="text-sm font-semibold text-gray-900">Lic. Enf. Rosa Campos</p>
              <p class="text-xs text-gray-600">rosa.campos@istp.edu.pe</p>
            </div>
            <div class="mt-4 flex space-x-2">
              <button class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 py-2 px-3 rounded text-sm font-medium">
                Editar
              </button>
              <button class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 py-2 px-3 rounded text-sm font-medium">
                Ver
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
import { ref } from 'vue';

const canManage = ref(true);
</script>
