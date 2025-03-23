<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
      <div class="bg-white shadow rounded-lg p-6 w-full max-w-3xl">
        <!-- Profile Header -->
        <div class="flex justify-between items-center border-b pb-4 mb-4">
          <h1 class="text-3xl font-bold text-gray-800">Profile</h1>
          <button
            @click="logout"
            class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 transition"
          >
            Logout
          </button>
        </div>
  
        <!-- User Info -->
        <div class="mb-6">
          <p class="text-lg"><span class="font-semibold">Name:</span> {{ user?.name }}</p>
          <p class="text-lg"><span class="font-semibold">Email:</span> {{ user?.email }}</p>
          <p class="text-lg"><span class="font-semibold">Logged in since:</span> {{ loginTime }}</p>
        </div>
  
        <!-- Tasks Overview -->
        <div>
          <h2 class="text-2xl font-semibold text-gray-700 mb-4">Your Tasks</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- To Do Column -->
            <div>
              <h3 class="text-xl font-medium text-blue-600 mb-2">To Do</h3>
              <ul>
                <li
                  v-for="task in todoTasks"
                  :key="task.id"
                  class="border p-2 rounded mb-2 bg-blue-50 text-blue-800"
                >
                  {{ task.title }}
                </li>
              </ul>
            </div>
            <!-- In Progress Column -->
            <div>
              <h3 class="text-xl font-medium text-yellow-600 mb-2">In Progress</h3>
              <ul>
                <li
                  v-for="task in inProgressTasks"
                  :key="task.id"
                  class="border p-2 rounded mb-2 bg-yellow-50 text-yellow-800"
                >
                  {{ task.title }}
                </li>
              </ul>
            </div>
            <!-- Done Column -->
            <div>
              <h3 class="text-xl font-medium text-green-600 mb-2">Done</h3>
              <ul>
                <li
                  v-for="task in doneTasks"
                  :key="task.id"
                  class="border p-2 rounded mb-2 bg-green-50 text-green-800"
                >
                  {{ task.title }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent, computed } from 'vue';
  import { useStore } from 'vuex';
  import { useRouter } from 'vue-router';
  
  export default defineComponent({
    setup() {
      const store = useStore();
      const router = useRouter();
  
      // Get the authenticated user from the store
      const user = computed(() => store.state.user);
  
      // Assume tasks are stored in state
      const tasks = computed(() => store.state.tasks || []);
      const todoTasks = computed(() => tasks.value.filter((task: any) => task.status === 'todo'));
      const inProgressTasks = computed(() =>
        tasks.value.filter((task: any) => task.status === 'in_progress')
      );
      const doneTasks = computed(() => tasks.value.filter((task: any) => task.status === 'done'));
  
      // For demonstration, using current time as "Logged in since" value.
      // You can replace this with a proper timestamp if available.
      const loginTime = computed(() => new Date().toLocaleString());
  
      const logout = async () => {
        await store.dispatch('logout');
        router.push('/login');
      };
  
      return {
        user,
        logout,
        todoTasks,
        inProgressTasks,
        doneTasks,
        loginTime,
      };
    },
  });
  </script>
  
  <style scoped>
  /* You can add additional custom styles here if desired */
  </style>
  