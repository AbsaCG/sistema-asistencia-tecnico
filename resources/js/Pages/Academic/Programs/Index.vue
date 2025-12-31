<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Programas Académicos</h1>
          <p class="mt-2 text-gray-600">Gestión de carreras y programas universitarios</p>
        </div>
        <Link
          href="/academic/programs/create"
          class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
        >
          + Nuevo Programa
        </Link>
      </div>

      <!-- Filter Section -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Filtrar por Facultad</label>
            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
              <option value="">Todas las facultades</option>
              <option value="1">Facultad de Ingeniería</option>
              <option value="2">Facultad de Ciencias</option>
              <option value="3">Facultad de Administración</option>
              <option value="4">Facultad de Humanidades</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Estado</label>
            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
              <option value="">Todos</option>
              <option value="1">Activos</option>
              <option value="0">Inactivos</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Búsqueda</label>
            <input
              type="text"
              placeholder="Buscar programa..."
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            />
          </div>
        </div>
      </div>

      <!-- Programs Table -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Programa</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Facultad</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Semestres</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Créditos</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coordinador</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <!-- Program Row -->
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ISC-2024</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Ingeniería en Sistemas</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Facultad de Ingeniería</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">8</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">240</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">coord.sistemas@university.edu</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Activo
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                <button class="text-indigo-600 hover:text-indigo-900">Editar</button>
                <button class="text-red-600 hover:text-red-900">Eliminar</button>
              </td>
            </tr>

            <!-- Program Row -->
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ICVL-2024</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Ingeniería Civil</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Facultad de Ingeniería</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">10</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">280</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">coord.civil@university.edu</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Activo
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                <button class="text-indigo-600 hover:text-indigo-900">Editar</button>
                <button class="text-red-600 hover:text-red-900">Eliminar</button>
              </td>
            </tr>

            <!-- Program Row -->
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ADE-2024</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Administración de Empresas</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Facultad de Administración</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">8</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">240</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">coord.adm@university.edu</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Activo
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                <button class="text-indigo-600 hover:text-indigo-900">Editar</button>
                <button class="text-red-600 hover:text-red-900">Eliminar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>
