<template>
  <div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Test Auth Data</h1>
    
    <div class="bg-white shadow rounded-lg p-6 space-y-4">
      <div>
        <h2 class="font-semibold text-lg">Raw Page Props:</h2>
        <pre class="bg-gray-100 p-4 rounded mt-2 text-xs overflow-auto">{{ JSON.stringify($page.props, null, 2) }}</pre>
      </div>
      
      <div>
        <h2 class="font-semibold text-lg">Auth Data:</h2>
        <pre class="bg-gray-100 p-4 rounded mt-2 text-xs overflow-auto">{{ JSON.stringify($page.props.auth, null, 2) }}</pre>
      </div>
      
      <div>
        <h2 class="font-semibold text-lg">User Data:</h2>
        <pre class="bg-gray-100 p-4 rounded mt-2 text-xs overflow-auto">{{ JSON.stringify($page.props.auth?.user, null, 2) }}</pre>
      </div>
      
      <div>
        <h2 class="font-semibold text-lg">Role Data:</h2>
        <pre class="bg-gray-100 p-4 rounded mt-2 text-xs overflow-auto">{{ JSON.stringify($page.props.auth?.user?.role, null, 2) }}</pre>
      </div>
    </div>
  </div>
</template>

<script setup>
// No imports needed, using $page global
</script>
