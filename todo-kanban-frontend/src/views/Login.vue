<template>
<div class="p-4 max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-4">Login</h1>
    <form @submit.prevent="login" class="space-y-4">
      <input v-model="email" type="email" placeholder="Email" class="w-full p-2 border rounded" />
      <input v-model="password" type="password" placeholder="Password" class="w-full p-2 border rounded" />
      <button type="submit" class="bg-blue-500 text-white p-2 rounded">Login</button>
    </form>
  </div>
</template>

<script lang = "ts">
import { defineComponent, ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

export default defineComponent({
    setup(){
        const store = useStore();
        const router = useRouter();
        const email = ref('');
        const password = ref('');

        const login = async() => {
            await store.dispatch('login', {email: email.value, password: password.value});
            router.push('/');
        };

        
        return {
            email, 
            password, 
            login
        };
    },

});
</script>