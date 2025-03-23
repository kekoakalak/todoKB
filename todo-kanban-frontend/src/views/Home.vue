<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow py-4 px-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-700">Kanban Board</h1>
        <button
          @click="logout"
          class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 transition"
        >
          Logout
        </button>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto py-8 px-4">
      <!-- Columns Container -->
      <div class="flex flex-col md:flex-row md:space-x-6">
        <!-- To Do Column -->
        <div class="flex-1 bg-white rounded-lg shadow p-4 mb-6 md:mb-0">
          <h2 class="text-xl font-semibold text-blue-600 mb-4">To Do</h2>
          <draggable v-model="todoTasks" group="tasks" @end="onDragEnd">
            <template #item="{ element }">
              <div class="bg-blue-50 border border-blue-200 rounded p-3 mb-3 shadow-sm">
                <div class="text-blue-800 font-medium">{{ element.title }}</div>
                <div class="mt-2 text-sm text-gray-600">{{ element.description }}</div>
                <div class="mt-3 flex space-x-2">
                  <button
                    @click="updateTaskStatus(element.id, 'in_progress')"
                    class="text-sm text-blue-600 hover:underline"
                  >
                    Next
                  </button>
                  <button
                    @click="deleteTask(element.id)"
                    class="text-sm text-red-500 hover:underline"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </template>
          </draggable>
        </div>

        <!-- In Progress Column -->
        <div class="flex-1 bg-white rounded-lg shadow p-4 mb-6 md:mb-0">
          <h2 class="text-xl font-semibold text-yellow-600 mb-4">In Progress</h2>
          <draggable v-model="inProgressTasks" group="tasks" @end="onDragEnd">
            <template #item="{ element }">
              <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-3 shadow-sm">
                <div class="text-yellow-800 font-medium">{{ element.title }}</div>
                <div class="mt-2 text-sm text-gray-600">{{ element.description }}</div>
                <div class="mt-3 flex space-x-2">
                  <button
                    @click="updateTaskStatus(element.id, 'done')"
                    class="text-sm text-green-600 hover:underline"
                  >
                    Next
                  </button>
                  <button
                    @click="deleteTask(element.id)"
                    class="text-sm text-red-500 hover:underline"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </template>
          </draggable>
        </div>

        <!-- Done Column -->
        <div class="flex-1 bg-white rounded-lg shadow p-4">
          <h2 class="text-xl font-semibold text-green-600 mb-4">Done</h2>
          <draggable v-model="doneTasks" group="tasks" @end="onDragEnd">
            <template #item="{ element }">
              <div class="bg-green-50 border border-green-200 rounded p-3 mb-3 shadow-sm">
                <div class="text-green-800 font-medium">{{ element.title }}</div>
                <div class="mt-2 text-sm text-gray-600">{{ element.description }}</div>
                <div class="mt-3 flex space-x-2">
                  <button
                    @click="deleteTask(element.id)"
                    class="text-sm text-red-500 hover:underline"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </template>
          </draggable>
        </div>
      </div>

      <!-- Task Creation Form -->
      <div class="mt-8 bg-white p-6 rounded-lg shadow max-w-xl mx-auto">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Create New Task</h3>
        <form @submit.prevent="createTask" class="space-y-4">
          <div>
            <input
              v-model="newTask.title"
              type="text"
              placeholder="Task Title"
              class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300"
            />
          </div>
          <div>
            <textarea
              v-model="newTask.description"
              placeholder="Description"
              class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300"
            ></textarea>
          </div>
          <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
          >
            Add Task
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed, onMounted, reactive } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import draggable from 'vuedraggable';

export default defineComponent({
  components: { draggable },
  setup() {
    const store = useStore();
    const router = useRouter();

    // Computed lists of tasks by status
    const tasks = computed(() => store.state.tasks);
    const todoTasks = computed(() => tasks.value.filter((task: any) => task.status === 'todo'));
    const inProgressTasks = computed(() => tasks.value.filter((task: any) => task.status === 'in_progress'));
    const doneTasks = computed(() => tasks.value.filter((task: any) => task.status === 'done'));

    // Reactive new task object
    const newTask = reactive({ title: '', description: '', status: 'todo' });

    // Fetch tasks on component mount
    onMounted(() => store.dispatch('fetchTasks'));

    const createTask = () => {
      store.dispatch('createTasks', { ...newTask });
      newTask.title = '';
      newTask.description = '';
    };

    const updateTaskStatus = (id: number, status: string) => {
      store.dispatch('updateTasks', { id, data: { status } });
    };

    const deleteTask = (id: number) => {
      store.dispatch('deleteTasks', id);
    };

    const onDragEnd = (event: any) => {
      // Optional: handle drag-and-drop event to update the task order or status
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
      createTask,
      updateTaskStatus,
      deleteTask,
      logout,
      onDragEnd,
    };
  },
});
</script>

<style scoped>
/* You can add any additional custom styles here if desired */
</style>
