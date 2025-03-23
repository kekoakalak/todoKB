<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Kanban Board</h1>
    <button @click="logout" class="bg-red-500 text-white p-2 rounded mb-4">Logout</button>
    <div class="flex space-x-4">
      <div class="bg-gray-100 p-4 rounded w-1/3">
        <h2 class="text-xl font-semibold mb-2">To Do</h2>
        <div v-for="task in todoTasks" :key="task.id" class="bg-white p-2 mb-2 rounded shadow">
          {{ task.title }}
          <button @click="updateTasks(task.id, 'in_progress')" class="text-blue-500 ml-2">Next</button>
          <button @click="deleteTasks(task.id)" class="text-red-500 ml-2">Delete</button>
        </div>
      </div>
      <div class="bg-gray-100 p-4 rounded w-1/3">
        <h2 class="text-xl font-semibold mb-2">In Progress</h2>
        <div v-for="task in inProgressTasks" :key="task.id" class="bg-white p-2 mb-2 rounded shadow">
          {{ task.title }}
          <button @click="updateTasks(task.id, 'done')" class="text-blue-500 ml-2">Next</button>
          <button @click="deleteTasks(task.id)" class="text-red-500 ml-2">Delete</button>
        </div>
      </div>
      <div class="bg-gray-100 p-4 rounded w-1/3">
        <h2 class="text-xl font-semibold mb-2">Done</h2>
        <div v-for="task in doneTasks" :key="task.id" class="bg-white p-2 mb-2 rounded shadow">
          {{ task.title }}
          <button @click="deleteTasks(task.id)" class="text-red-500 ml-2">Delete</button>
        </div>
      </div>
    </div>
    <form @submit.prevent="createTasks" class="mt-4 space-y-2">
      <input v-model="newTask.title" placeholder="Task Title" class="p-2 border rounded" />
      <input v-model="newTask.description" placeholder="Description" class="p-2 border rounded" />
      <button type="submit" class="bg-green-500 text-white p-2 rounded">Add Task</button>
    </form>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed, onMounted, reactive } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';


export default defineComponent({

  setup(){
    const store = useStore();
    const router = useRouter();

    const tasks = computed(() => store.state.tasks);
    const todoTasks = computed(() => tasks.value.filter((task:any) => task.status === 'todo'));
    const inProgressTasks = computed(() => tasks.value.filter((task:any) => task.status === 'in_progress'));
    const doneTasks = computed(() => tasks.value.filter((task:any) => task.status === 'done'));

    const newTask = reactive({title: '', description: '', status: 'todo'});

    onMounted(() => store.dispatch('fetchTasks'));

    const createTasks = () =>{
      store.dispatch('createTasks', {...newTask});
      newTask.title = '';
      newTask.description = '';
    };

    const updateTasks = (id: number, status: string) => {
      store.dispatch('updateTasks', {id, data: {status}});
    };
    
    const deleteTasks = (id: number) => {
      store.dispatch('deleteTasks', id);

    };

    const logout = () => {
      store.dispatch('logout');
      router.push('/login');
    };


    return {
      todoTasks,
      inProgressTasks,
      doneTasks,
      newTask,
      createTasks,
      updateTasks,
      deleteTasks,
      logout
    };

  },


});

</script>
