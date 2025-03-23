<template>
    <div class="p-4 max-w-md mx-auto">
      <h1 class="text-2xl font-bold mb-4">Profile</h1>
      <p>Name: {{ user?.name }}</p>
      <p>Email: {{ user?.email }}</p>
      <button @click="logout" class="bg-red-500 text-white p-2 rounded mt-4">Logout</button>
    </div>
  </template>



<script lang="ts">
import {defineComponent, computed} from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

export default defineComponent({

    setup(){
        const store = useStore();
        const router = useRouter();
        const user = computed(() => store.state.user);


        const logout = async() => {
            store.dispatch('logout');
            router.push('/login');


        };

        return {
            user,
            logout
        };
    },


});


</script>