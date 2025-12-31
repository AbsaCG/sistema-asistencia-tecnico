<template>
  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <div class="flex items-center">
        <div :class="['flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-lg', colorBg]">
          <svg v-if="icon === 'users'" class="w-6 h-6" :class="colorText" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
          <svg v-else-if="icon === 'check'" class="w-6 h-6" :class="colorText" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
          <svg v-else-if="icon === 'x'" class="w-6 h-6" :class="colorText" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          <svg v-else-if="icon === 'building'" class="w-6 h-6" :class="colorText" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7v5a1 1 0 001 1h2v3a1 1 0 001 1h2a1 1 0 001-1v-3h2v3a1 1 0 001 1h2a1 1 0 001-1v-3h2a1 1 0 001-1v-5l-7-7z"></path></svg>
        </div>
        <div class="ml-5 w-0 flex-1">
          <dl>
            <dt class="text-sm font-medium text-gray-500 truncate">{{ label }}</dt>
            <dd class="text-lg font-medium" :class="valueColor">{{ value }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  value: {
    type: [String, Number],
    required: true,
  },
  icon: {
    type: String,
    default: 'users', // users, check, x, building
  },
  type: {
    type: String,
    default: 'default', // default, success, danger, warning, info
  },
});

const colorMap = {
  default: { bg: 'bg-gray-100', text: 'text-gray-600', valueColor: 'text-gray-900' },
  success: { bg: 'bg-green-100', text: 'text-green-600', valueColor: 'text-green-600' },
  danger: { bg: 'bg-red-100', text: 'text-red-600', valueColor: 'text-red-600' },
  warning: { bg: 'bg-yellow-100', text: 'text-yellow-600', valueColor: 'text-yellow-600' },
  info: { bg: 'bg-blue-100', text: 'text-blue-600', valueColor: 'text-blue-600' },
};

const colorBg = computed(() => colorMap[props.type]?.bg || colorMap.default.bg);
const colorText = computed(() => colorMap[props.type]?.text || colorMap.default.text);
const valueColor = computed(() => colorMap[props.type]?.valueColor || colorMap.default.valueColor);
</script>
