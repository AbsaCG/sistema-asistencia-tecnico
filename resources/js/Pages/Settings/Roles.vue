<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Roles & Permissions</h1>

    <div class="mb-6">
      <form @submit.prevent="createRole" class="flex gap-2">
        <input v-model="newRole.name" placeholder="Role name" class="border p-2" />
        <input v-model="newRole.slug" placeholder="slug" class="border p-2" />
        <button class="bg-blue-600 text-white px-3 py-2 rounded">Create</button>
      </form>
    </div>

    <div class="grid gap-4">
      <div v-for="role in roles" :key="role.id" class="border p-4 rounded">
        <div class="flex justify-between items-center">
          <div>
            <div class="font-semibold">{{ role.name }} <small class="text-sm text-gray-500">({{ role.slug }})</small></div>
          </div>
          <div class="flex gap-2">
            <button @click="editing = role" class="px-2 py-1 border rounded">Edit</button>
            <form :action="route('settings.roles.destroy', role.id)" method="post">
              <input type="hidden" name="_method" value="delete" />
              <input type="hidden" name="_token" :value="csrf" />
              <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded">Delete</button>
            </form>
          </div>
        </div>
        <div class="mt-3 text-sm">
          <div v-if="role.permission_models && role.permission_models.length">
            <span v-for="p in role.permission_models" :key="p.id" class="inline-block mr-2 px-2 py-1 bg-gray-100 rounded">{{ p.slug }}</span>
          </div>
          <div v-else class="text-gray-500">No permissions assigned</div>
        </div>
      </div>
    </div>

    <div v-if="editing" class="fixed inset-0 bg-black/30 flex items-center justify-center">
      <div class="bg-white p-6 rounded w-2/3">
        <h2 class="text-xl font-semibold mb-3">Edit {{ editing.name }}</h2>
        <form :action="route('settings.roles.update', editing.id)" method="post">
          <input type="hidden" name="_method" value="put" />
          <input type="hidden" name="_token" :value="csrf" />
          <div class="mb-3">
            <label class="block text-sm">Name</label>
            <input name="name" v-model="editing.name" class="border p-2 w-full" />
          </div>
          <div class="mb-3">
            <label class="block text-sm">Slug</label>
            <input name="slug" v-model="editing.slug" class="border p-2 w-full" />
          </div>
          <div class="mb-3">
            <label class="block text-sm font-medium mb-2">Permissions</label>
            <div class="grid grid-cols-3 gap-2">
              <label v-for="perm in permissions" :key="perm.id" class="flex items-center gap-2">
                <input type="checkbox" :value="perm.id" :checked="hasPermission(editing, perm.id)" :name="`permissions[]`" />
                <span class="text-sm">{{ perm.slug }}</span>
              </label>
            </div>
          </div>
          <div class="flex gap-2 justify-end">
            <button type="button" @click="editing = null" class="px-3 py-2 border">Cancel</button>
            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'

export default {
  setup() {
    const page = usePage()
    const roles = ref(page.props.value.roles || [])
    const permissions = ref(page.props.value.permissions || [])
    const csrf = page.props.value.csrf

    const newRole = ref({ name: '', slug: '' })
    const editing = ref(null)

    function createRole() {
      const form = document.createElement('form')
      form.method = 'post'
      form.action = route('settings.roles.store')
      const token = document.createElement('input')
      token.type = 'hidden'
      token.name = '_token'
      token.value = csrf
      form.appendChild(token)

      const name = document.createElement('input')
      name.name = 'name'
      name.value = newRole.value.name
      form.appendChild(name)

      const slug = document.createElement('input')
      slug.name = 'slug'
      slug.value = newRole.value.slug
      form.appendChild(slug)

      document.body.appendChild(form)
      form.submit()
    }

    function hasPermission(role, permId) {
      if (!role.permission_models) return false
      return role.permission_models.some(p => p.id === permId)
    }

    return { roles, permissions, newRole, createRole, editing, hasPermission, csrf }
  }
}
</script>

<style scoped>
</style>
