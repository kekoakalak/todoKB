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

import {defineComponent, ref} from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

export default defineComponent({

    setup(){
        const store = useStore();
        const router = useRouter();
        const name = ref('');
        const email = ref('');
        const password = ref('');

        const register = async() => {
            await store.dispatch('register', {name: name.value, email: email.value, password: password.value});
            router.push('/login');
        };
        

        return {
            name,
            email,
            password,
            register
        }
    },

    

});

</script>