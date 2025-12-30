import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

export const useAuthStore = defineStore('auth', () => {
  const page = usePage();
  
  const user = computed(() => page.props.auth?.user || null);
  const isAuthenticated = computed(() => !!user.value);
  const userRole = computed(() => user.value?.role?.slug || null);
  const userName = computed(() => user.value?.name || '');

  const hasPermission = (permission) => {
    if (!user.value?.role?.permissions) return false;
    const permissions = JSON.parse(user.value.role.permissions);
    return permissions.includes(permission);
  };

  const hasRole = (role) => {
    return userRole.value === role;
  };

  const hasAnyRole = (roles) => {
    return roles.includes(userRole.value);
  };

  return {
    user,
    isAuthenticated,
    userRole,
    userName,
    hasPermission,
    hasRole,
    hasAnyRole,
  };
});
