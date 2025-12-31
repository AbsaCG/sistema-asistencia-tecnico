<template>
  <AppLayout>
    <div class="space-y-4 sm:space-y-6">
      <!-- Header -->
      <div>
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Panel de Control</h1>
        <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Sistema de Gestión de Asistencia</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <StatCard
          label="Estudiantes Inscritos"
          :value="stats.totalStudents"
          icon="users"
          type="default"
        />
        <StatCard
          label="Presentes Hoy"
          :value="`${stats.presentToday} (${stats.attendancePercentage}%)`"
          icon="check"
          type="success"
        />
        <StatCard
          label="Ausentes Hoy"
          :value="`${stats.absentToday}`"
          icon="x"
          type="danger"
        />
        <StatCard
          label="Carreras Técnicas"
          :value="stats.totalCareers"
          icon="building"
          type="info"
        />
      </div>

      <!-- Gráficos -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        <!-- Gráfico de Asistencias por Día -->
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 overflow-hidden">
          <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">📈 Últimos 7 Días</h3>
          <div class="w-full overflow-x-auto">
            <Line :data="lineChartData" :options="lineChartOptions" />
          </div>
        </div>

        <!-- Gráfico de Asistencias de Hoy -->
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 overflow-hidden">
          <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">🥧 Distribución Hoy</h3>
          <div class="w-full overflow-x-auto">
            <Doughnut :data="doughnutChartData" :options="doughnutChartOptions" />
          </div>
        </div>
      </div>

      <!-- Gráfico de Asistencias por Carrera -->
      <div class="bg-white shadow rounded-lg p-4 sm:p-6 overflow-hidden">
        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">🎓 Por Carrera (Hoy)</h3>
        <div class="w-full overflow-x-auto">
          <Bar :data="barChartData" :options="barChartOptions" />
        </div>
      </div>

      <!-- Acciones Rápidas -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-4 sm:p-6">
          <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900 mb-3 sm:mb-4">⚡ Acciones Rápidas</h3>
          <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Registrar Asistencia -->
            <Link
              href="/attendance/register"
              class="group flex items-center justify-center px-3 py-2.5 sm:px-4 sm:py-3 border border-transparent text-xs sm:text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition"
            >
              <span class="text-base sm:text-lg mr-2">📋</span>
              <span class="truncate">Registrar</span>
            </Link>
            <!-- Ver Carreras -->
            <Link
              href="/academic/careers"
              class="group flex items-center justify-center px-3 py-2.5 sm:px-4 sm:py-3 border border-transparent text-xs sm:text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 transition"
            >
              <span class="text-base sm:text-lg mr-2">🎓</span>
              <span class="truncate">Carreras</span>
            </Link>
            <!-- Gestionar Estudiantes -->
            <Link
              href="/students"
              class="group flex items-center justify-center px-3 py-2.5 sm:px-4 sm:py-3 border border-transparent text-xs sm:text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 transition"
            >
              <span class="text-base sm:text-lg mr-2">👥</span>
              <span class="truncate">Estudiantes</span>
            </Link>
            <!-- Reportes y Análisis -->
            <Link
              href="/reports/attendance"
              class="group flex items-center justify-center px-3 py-2.5 sm:px-4 sm:py-3 border border-transparent text-xs sm:text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 transition"
            >
              <span class="text-base sm:text-lg mr-2">📊</span>
              <span class="truncate">Reportes</span>
            </Link>
          </div>
        </div>
      </div>

      <!-- Additional Insights -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-white shadow rounded-lg lg:col-span-2">
          <div class="px-4 py-4 sm:p-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900 mb-3 sm:mb-4">📅 Próximas Sesiones</h3>
            <ul class="divide-y">
              <li class="py-2 sm:py-3 flex justify-between items-start">
                <div>
                  <div class="text-xs sm:text-sm font-medium text-gray-900">Fundamentos de Programación - III Ciclo</div>
                  <div class="text-xs sm:text-sm text-gray-500">08:00 - Laboratorio 2</div>
                </div>
                <div class="text-xs sm:text-sm text-gray-500">Hoy</div>
              </li>
              <li class="py-2 sm:py-3 flex justify-between items-start">
                <div>
                  <div class="text-xs sm:text-sm font-medium text-gray-900">Diseño de Sistemas - IV Ciclo</div>
                  <div class="text-xs sm:text-sm text-gray-500">10:00 - Aula 301</div>
                </div>
                <div class="text-sm text-gray-500">Hoy</div>
              </li>
              <li class="py-3 flex justify-between items-start">
                <div>
                  <div class="text-sm font-medium text-gray-900">Taller de Mantenimiento - II Ciclo</div>
                  <div class="text-sm text-gray-500">14:00 - Taller A</div>
                </div>
                <div class="text-sm text-gray-500">Hoy</div>
              </li>
            </ul>
          </div>
        </div>

        <div class="bg-white shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">🔔 Justificaciones Pendientes</h3>
            <div class="text-sm text-gray-600">{{ pendingJustifications }} solicitudes pendientes</div>
            <ul class="mt-3 space-y-2 text-sm">
              <li v-if="pendingJustifications === 0" class="text-center py-4 text-gray-400">Sin solicitudes pendientes</li>
              <template v-else>
                <li class="flex justify-between"><span>Revisar solicitudes</span><Link href="/justifications" class="text-indigo-600 hover:text-indigo-800">Ver todas</Link></li>
              </template>
            </ul>
          </div>
        </div>
      </div>

      <!-- Actividad Reciente -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900">📍 Asistencias en Tiempo Real</h3>
            <div class="flex items-center text-xs text-gray-500">
              <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></div>
              Actualizando cada 5s
            </div>
          </div>
          <div class="space-y-3 max-h-96 overflow-y-auto">
            <template v-if="recentActivity.length > 0">
              <div v-for="activity in recentActivity" :key="activity.id" 
                   class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                <div :class="['w-3 h-3 rounded-full flex-shrink-0', 
                              activity.type === 'present' ? 'bg-green-600' : 
                              activity.type === 'absent' ? 'bg-red-600' : 'bg-yellow-600']"></div>
                <div class="ml-3 flex-1">
                  <div class="font-medium text-gray-900">{{ activity.student_name }}</div>
                  <div class="text-xs text-gray-500">{{ activity.action }}</div>
                </div>
                <span class="ml-auto text-sm font-semibold text-gray-600">{{ formatTime(activity.timestamp) }}</span>
              </div>
            </template>
            <div v-else class="text-center py-8 text-gray-400">
              <div class="text-4xl mb-2">👥</div>
              <div class="text-sm">Esperando registros de asistencia...</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import StatCard from '@/Components/StatCard.vue';
import { Link, router } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  ArcElement,
  Title,
  Tooltip,
  Legend,
  Filler
} from 'chart.js';
import { Line, Doughnut, Bar } from 'vue-chartjs';

// Registrar componentes de Chart.js
ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  ArcElement,
  Title,
  Tooltip,
  Legend,
  Filler
);

const props = defineProps({
  stats: {
    type: Object,
    required: true,
  },
  pendingJustifications: {
    type: Number,
    default: 0,
  },
  recentActivity: {
    type: Array,
    default: () => [],
  },
  chartData: {
    type: Object,
    default: () => ({
      last7Days: [],
      attendanceByDay: [],
      attendanceByCareer: [],
    }),
  },
});

// Gráfico de línea - Asistencias por día
const lineChartData = computed(() => {
  const presentData = props.chartData.attendanceByDay.map(day => day.present);
  const absentData = props.chartData.attendanceByDay.map(day => day.absent);
  const lateData = props.chartData.attendanceByDay.map(day => day.late);

  return {
    labels: props.chartData.last7Days,
    datasets: [
      {
        label: 'Presentes',
        data: presentData,
        borderColor: '#10b981',
        backgroundColor: 'rgba(16, 185, 129, 0.1)',
        tension: 0.4,
        fill: true,
      },
      {
        label: 'Ausentes',
        data: absentData,
        borderColor: '#ef4444',
        backgroundColor: 'rgba(239, 68, 68, 0.1)',
        tension: 0.4,
        fill: true,
      },
      {
        label: 'Tarde',
        data: lateData,
        borderColor: '#f59e0b',
        backgroundColor: 'rgba(245, 158, 11, 0.1)',
        tension: 0.4,
        fill: true,
      },
    ],
  };
});

const lineChartOptions = {
  responsive: true,
  maintainAspectRatio: true,
  aspectRatio: window.innerWidth < 640 ? 1.2 : 2,
  plugins: {
    legend: {
      position: 'top',
      labels: {
        boxWidth: window.innerWidth < 640 ? 10 : 12,
        padding: window.innerWidth < 640 ? 8 : 10,
        font: {
          size: window.innerWidth < 640 ? 10 : 12,
        }
      }
    },
    tooltip: {
      mode: 'index',
      intersect: false,
    },
  },
  scales: {
    y: {
      beginAtZero: true,
      ticks: {
        stepSize: 1,
        font: {
          size: window.innerWidth < 640 ? 10 : 12,
        }
      },
    },
    x: {
      ticks: {
        font: {
          size: window.innerWidth < 640 ? 10 : 12,
        }
      }
    }
  },
};

// Gráfico de dona - Distribución de hoy
const doughnutChartData = computed(() => ({
  labels: ['Presentes', 'Ausentes', 'Tarde'],
  datasets: [
    {
      data: [props.stats.presentToday, props.stats.absentToday, props.stats.lateToday],
      backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
      borderWidth: 2,
      borderColor: '#fff',
    },
  ],
}));

const doughnutChartOptions = {
  responsive: true,
  maintainAspectRatio: true,
  aspectRatio: window.innerWidth < 640 ? 1.2 : 2,
  plugins: {
    legend: {
      position: 'bottom',
      labels: {
        boxWidth: window.innerWidth < 640 ? 10 : 12,
        padding: window.innerWidth < 640 ? 8 : 10,
        font: {
          size: window.innerWidth < 640 ? 10 : 12,
        }
      }
    },
    tooltip: {
      callbacks: {
        label: function(context) {
          const label = context.label || '';
          const value = context.parsed || 0;
          const total = context.dataset.data.reduce((a, b) => a + b, 0);
          const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
          return `${label}: ${value} (${percentage}%)`;
        },
      },
    },
  },
};

// Gráfico de barras - Asistencias por carrera
const barChartData = computed(() => ({
  labels: props.chartData.attendanceByCareer.map(c => c.name),
  datasets: [
    {
      label: 'Presentes',
      data: props.chartData.attendanceByCareer.map(c => c.present),
      backgroundColor: '#10b981',
    },
    {
      label: 'Total Estudiantes',
      data: props.chartData.attendanceByCareer.map(c => c.total),
      backgroundColor: '#6b7280',
    },
  ],
}));

const barChartOptions = {
  responsive: true,
  maintainAspectRatio: true,
  aspectRatio: 3,
  plugins: {
    legend: {
      position: 'top',
    },
    tooltip: {
      mode: 'index',
      intersect: false,
    },
  },
  scales: {
    y: {
      beginAtZero: true,
      ticks: {
        stepSize: 1,
      },
    },
  },
};

const formatTime = (timestamp) => {
  const date = new Date(timestamp);
  const now = new Date();
  const diffMinutes = Math.floor((now - date) / 60000);
  
  if (diffMinutes < 1) return 'Ahora';
  if (diffMinutes < 60) return `Hace ${diffMinutes}m`;
  
  const diffHours = Math.floor(diffMinutes / 60);
  if (diffHours < 24) return `Hace ${diffHours}h`;
  
  const diffDays = Math.floor(diffHours / 24);
  if (diffDays < 7) return `Hace ${diffDays}d`;
  
  return date.toLocaleDateString();
};

// Auto-refresh para mostrar actividad en tiempo real
let refreshInterval = null;
const lastRefresh = ref(new Date());

onMounted(() => {
  // Refrescar cada 5 segundos
  refreshInterval = setInterval(() => {
    router.reload({ only: ['stats', 'recentActivity', 'pendingJustifications'] });
    lastRefresh.value = new Date();
  }, 5000);
});

onUnmounted(() => {
  if (refreshInterval) {
    clearInterval(refreshInterval);
  }
});
</script>
