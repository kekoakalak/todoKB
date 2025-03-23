<template>
    <div class="p-4 max-w-md mx-auto">
      <h1 class="text-2xl font-bold mb-4">Register</h1>
      <form @submit.prevent="register" class="space-y-4">
        <input v-model="name" type="text" placeholder="Name" class="w-full p-2 border rounded" />
        <input v-model="email" type="email" placeholder="Email" class="w-full p-2 border rounded" />
        <input v-model="password" type="password" placeholder="Password" class="w-full p-2 border rounded" />
        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Register</button>
      </form>
    </div>
  </template>

  <script lang ="ts">

</script>