<template>
  <div>
    <!-- Only display nav if showNav is true -->
    <nav v-if="showNav" class="bg-white shadow py-4 px-6">
      <router-link to="/" class="text-gray-600 hover:text-gray-800 mr-4">Home</router-link>
      <router-link to="/profile" class="text-gray-600 hover:text-gray-800">Profile</router-link>
    </nav>
    <router-view />
  </div>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue';
import { useRoute } from 'vue-router';

export default defineComponent({
  setup() {
    const route = useRoute();

    // Hide nav if route path is '/login' or '/register'
    const showNav = computed(() => {
      return !['/login', '/register'].includes(route.path);
    });

    return {
      showNav,
    };
  },
});
</script>

<style scoped>
/* Add any additional styles if needed */
</style>
