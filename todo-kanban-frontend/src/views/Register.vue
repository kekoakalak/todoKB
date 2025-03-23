<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="p-6 max-w-md w-full bg-white shadow rounded">
      <h1 class="text-2xl font-bold mb-4 text-center">Register</h1>
      <form @submit.prevent="register" class="space-y-4">
        <input v-model="name" type="text" placeholder="Name" class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300" />
        <input v-model="email" type="email" placeholder="Email" class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300" />
        <input v-model="password" type="password" placeholder="Password" class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300" />
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition">
          Register
        </button>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

export default defineComponent({
  setup() {
    const store = useStore();
    const router = useRouter();
    const name = ref('');
    const email = ref('');
    const password = ref('');

    const register = async () => {
      await store.dispatch('register', { name: name.value, email: email.value, password: password.value });
      router.push('/login');
    };

    return {
      name,
      email,
      password,
      register,
    };
  },
});
</script>

<style scoped>
/* Additional custom styles can be added here if needed */
</style>
