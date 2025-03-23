<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
      <div class="p-6 max-w-md w-full bg-white shadow rounded">
        <h1 class="text-2xl font-bold mb-4 text-center">Login</h1>
        <form @submit.prevent="login" class="space-y-4">
          <input
            v-model="email"
            type="email"
            placeholder="Email"
            class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
          />
          <input
            v-model="password"
            type="password"
            placeholder="Password"
            class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
          />
          <button
            type="submit"
            class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition"
          >
            Login
          </button>
        </form>
        <!-- Error message -->
        <p v-if="errorMessage" class="mt-4 text-center text-sm text-red-500">
          {{ errorMessage }}
        </p>
        <p class="mt-4 text-center text-sm text-gray-600">
          Don't have an account?
          <router-link to="/register" class="text-blue-500 hover:underline">
            Register!
          </router-link>
        </p>
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
      const email = ref('');
      const password = ref('');
      const errorMessage = ref('');
  
      const login = async () => {
        try {
          await store.dispatch('login', {
            email: email.value,
            password: password.value,
          });
          router.push('/');
        } catch (error) {
          // Display a generic error message. Optionally, inspect error response for details.
          errorMessage.value = 'Invalid email or password. Please try again.';
        }
      };
  
      return {
        email,
        password,
        login,
        errorMessage,
      };
    },
  });
  </script>
  