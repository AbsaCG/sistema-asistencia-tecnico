<template>
  <div class="min-h-screen bg-gray-100 flex overflow-x-hidden">
    <!-- Sidebar Mobile Overlay -->
    <div v-if="sidebarOpen" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden" @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <aside :class="['fixed lg:relative lg:block z-50 w-64 bg-white border-r h-screen overflow-y-auto transition-transform', sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0']">
      <div class="p-4">
        <div class="flex justify-between items-center mb-6">
          <div class="text-lg sm:text-xl font-bold text-indigo-600">🎓 ISTP Control</div>
          <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <nav class="space-y-1 text-sm">
          <!-- MENÚ PARA ESTUDIANTES -->
          <template v-if="hasRole('student')">
            <!-- Dashboard -->
            <Link href="/student/dashboard" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 font-medium">
              <span class="mr-2">🏠</span> Mi Dashboard
            </Link>
            
            <!-- Mi Área Estudiantil -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">📚 Mi Área</div>
            <Link href="/student/my-attendances" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📊</span> Mis Asistencias
            </Link>
            <Link href="/student/schedule" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📅</span> Mi Horario
            </Link>
            <Link href="/student/justifications" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📝</span> Mis Justificaciones
            </Link>
            <Link href="/student/profile" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">👤</span> Mi Perfil
            </Link>
            <Link href="/student/notifications" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🔔</span> Notificaciones
            </Link>
            
            <!-- Ayuda -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">ℹ️ Ayuda</div>
            <a href="/" target="_blank" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🏠</span> Página Principal
            </a>
            <Link href="/dashboard" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">❓</span> Centro de Ayuda
            </Link>
          </template>

          <!-- MENÚ PARA DOCENTES -->
          <template v-if="hasRole('teacher')">
            <!-- Dashboard -->
            <Link href="/dashboard" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 font-medium">
              <span class="mr-2">🏠</span> Dashboard
            </Link>
            
            <!-- Gestión de Asistencia -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">📋 Asistencia</div>
            <Link href="/attendance/register" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">✅</span> Registrar Asistencia
            </Link>
            <Link href="/attendance" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📊</span> Ver Asistencias
            </Link>
            <Link href="/justifications" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📄</span> Justificaciones
            </Link>
            
            <!-- Gestión Académica -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">📚 Académico</div>
            <Link href="/students" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">👥</span> Estudiantes
            </Link>
            <Link href="/courses" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📚</span> Mis Cursos
            </Link>
            <Link href="/academic/schedules" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🕐</span> Horarios
            </Link>
            
            <!-- Reportes -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">📈 Reportes</div>
            <Link href="/reports/attendance" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📊</span> Reporte de Asistencia
            </Link>
            <Link href="/reports/statistics" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📈</span> Estadísticas
            </Link>
            
            <!-- Ayuda -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">ℹ️ Ayuda</div>
            <Link href="/notifications" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🔔</span> Notificaciones
            </Link>
            <a href="/" target="_blank" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🏠</span> Página Principal
            </a>
            <Link href="/dashboard" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">❓</span> Centro de Ayuda
            </Link>
          </template>

          <!-- MENÚ PARA ADMIN (COMPLETO) -->
          <template v-if="hasRole('admin')">
            <!-- Dashboard -->
            <Link href="/dashboard" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 font-medium">
              <span class="mr-2">🏠</span> Dashboard
            </Link>
            
            <!-- Gestión de Asistencia -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">📋 Asistencia</div>
            <Link href="/attendance/register" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">✅</span> Registrar Asistencia
            </Link>
            <Link href="/attendance" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📊</span> Ver Asistencias
            </Link>
            <Link href="/academic/attendance/gate" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🚪</span> Control de Puerta
            </Link>
            <Link href="/justifications" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📄</span> Justificaciones
            </Link>
            
            <!-- Gestión Académica -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">📚 Académico</div>
            <Link href="/students" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">👥</span> Estudiantes
            </Link>
            <Link href="/teachers" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">👨‍🏫</span> Docentes
            </Link>
            <Link href="/courses" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📚</span> Cursos
            </Link>
            <Link href="/academic/schedules" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🕐</span> Horarios
            </Link>
            <Link href="/academic/careers" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🎓</span> Carreras Técnicas
            </Link>
            <Link href="/academic/faculties" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🏛️</span> Facultades
            </Link>
            <Link href="/academic/years" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📆</span> Años Académicos
            </Link>
            
            <!-- Reportes y Análisis -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">📈 Reportes</div>
            <Link href="/reports/attendance" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📊</span> Reporte de Asistencia
            </Link>
            <Link href="/reports/statistics" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📈</span> Estadísticas
            </Link>
            
            <!-- Administración del Sistema -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">⚙️ Sistema</div>
            <Link href="/import" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📥</span> Importar Estudiantes
            </Link>
            <Link href="/users" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">👤</span> Usuarios
            </Link>
            <Link href="/settings/roles" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🔑</span> Roles y Permisos
            </Link>
            <Link href="/settings/system" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">⚙️</span> Configuración
            </Link>
            <Link href="/logs" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📋</span> Logs del Sistema
            </Link>
            
            <!-- Comunicaciones -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">💬 Comunicación</div>
            <Link href="/notifications" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🔔</span> Notificaciones
            </Link>
            
            <!-- Ayuda -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">ℹ️ Ayuda</div>
            <a href="/" target="_blank" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🏠</span> Página Principal
            </a>
            <Link href="/dashboard" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">❓</span> Centro de Ayuda
            </Link>
          </template>

          <!-- MENÚ PARA STAFF -->
          <template v-if="hasRole('staff')">
            <!-- Dashboard -->
            <Link href="/dashboard" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 font-medium">
              <span class="mr-2">🏠</span> Dashboard
            </Link>
            
            <!-- Gestión de Asistencia -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">📋 Asistencia</div>
            <Link href="/attendance/register" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">✅</span> Registrar Asistencia
            </Link>
            <Link href="/attendance" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📊</span> Ver Asistencias
            </Link>
            
            <!-- Consultas -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">📚 Consultas</div>
            <Link href="/students" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">👥</span> Estudiantes
            </Link>
            <Link href="/reports/attendance" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📊</span> Reportes
            </Link>
            
            <!-- Ayuda -->
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">ℹ️ Ayuda</div>
            <a href="/" target="_blank" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🏠</span> Página Principal
            </a>
            <Link href="/dashboard" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">❓</span> Centro de Ayuda
            </Link>
          </template>

          <!-- MENÚ POR DEFECTO (si no se detecta ningún rol específico) -->
          <template v-if="!hasRole('student') && !hasRole('teacher') && !hasRole('admin') && !hasRole('staff')">
            <Link href="/dashboard" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 font-medium">
              <span class="mr-2">🏠</span> Dashboard
            </Link>
            
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">📋 General</div>
            <Link href="/attendance" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📊</span> Asistencias
            </Link>
            <Link href="/students" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">👥</span> Estudiantes
            </Link>
            <Link href="/teachers" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">👨‍🏫</span> Docentes
            </Link>
            <Link href="/courses" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">📚</span> Cursos
            </Link>
            
            <div class="pt-3 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">ℹ️ Ayuda</div>
            <a href="/" target="_blank" class="flex items-center px-3 py-2 rounded hover:bg-indigo-50 text-gray-700">
              <span class="mr-2">🏠</span> Página Principal
            </a>
          </template>
        </nav>
      </div>
    </aside>

    <div class="flex-1">
      <!-- Navbar -->
      <nav class="bg-white shadow-sm sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <!-- Menu Toggle (Mobile) -->
            <div class="flex items-center lg:hidden">
              <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
              </button>
            </div>

            <!-- Logo (Desktop) -->
            <div class="flex items-center hidden lg:block">
              <Link href="/dashboard" class="text-xl font-bold text-indigo-600">🎓 ISTP Control</Link>
            </div>

            <!-- Nav Links (Desktop) -->
            <div class="hidden lg:flex items-center space-x-8">
              <Link href="/dashboard" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Dashboard</Link>
              
              <!-- Links para Estudiantes -->
              <template v-if="hasRole('student')">
                <Link href="/student/my-attendances" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Mis Asistencias</Link>
                <Link href="/student/schedule" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Horario</Link>
                <Link href="/student/justifications" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Justificaciones</Link>
              </template>
              
              <!-- Links para Docentes -->
              <template v-if="hasRole('teacher')">
                <Link href="/attendance/register" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Registrar</Link>
                <Link href="/students" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Estudiantes</Link>
                <Link href="/courses" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Cursos</Link>
                <Link href="/reports/attendance" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Reportes</Link>
              </template>
              
              <!-- Links para Admin -->
              <template v-if="hasRole('admin')">
                <Link href="/students" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Estudiantes</Link>
                <Link href="/attendance" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Asistencia</Link>
                <Link href="/reports/attendance" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Reportes</Link>
                <Link href="/import" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Importar</Link>
                <Link href="/settings/system" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Config</Link>
              </template>
              
              <!-- Links para Staff -->
              <template v-if="hasRole('staff')">
                <Link href="/attendance/register" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Registrar</Link>
                <Link href="/attendance" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Asistencias</Link>
                <Link href="/students" class="px-1 pt-1 border-b-2 text-sm font-medium text-gray-600 hover:text-gray-900">Estudiantes</Link>
              </template>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-2 sm:space-x-4">
              <div class="hidden sm:flex items-center space-x-2">
                <span class="text-xs sm:text-sm text-gray-600 truncate max-w-[120px] sm:max-w-none">{{ userName }}</span>
                <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded truncate">{{ userRole }}</span>
              </div>
              <form @submit.prevent="logout" method="POST" action="/logout" class="inline">
                <button type="submit" class="text-xs sm:text-sm text-gray-600 hover:text-gray-900 px-2 py-1">Salir</button>
              </form>
            </div>
          </div>
        </div>
      </nav>

      <!-- Main Content -->
      <main class="w-full max-w-7xl mx-auto py-4 px-4 sm:py-6 sm:px-6 lg:px-8">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const sidebarOpen = ref(false);

// Direct auth data from page props
const user = computed(() => page.props.auth?.user || {});
const userName = computed(() => user.value?.name || '');
const userRole = computed(() => user.value?.role?.name || user.value?.role?.slug || '');

const hasRole = (role) => {
  const roleName = (user.value?.role?.name || '').toString().toLowerCase().trim();
  const roleSlug = (user.value?.role?.slug || '').toString().toLowerCase().trim();
  
  if (Array.isArray(role)) {
    return role.some(r => {
      const targetRole = (r || '').toString().toLowerCase().trim();
      return targetRole === roleName || targetRole === roleSlug;
    });
  }
  
  const targetRole = (role || '').toString().toLowerCase().trim();
  return targetRole === roleName || targetRole === roleSlug;
};

const hasAnyRole = (roles) => {
  if (!Array.isArray(roles)) return false;
  return roles.some(role => hasRole(role));
};

const logout = () => {
  router.post('/logout');
};
</script>
