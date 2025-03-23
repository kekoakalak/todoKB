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
        <div class="flex-1 bg-white rounded-lg shadow p-4 mb-6 md:mb-0" data-status="todo">
          <h2 class="text-xl font-semibold text-blue-600 mb-4 text-center">To Do</h2>
          <draggable
            v-model="todoTasks"
            group="tasks"
            @end="handleDragEnd($event, 'todo')"
          >
            <template #item="{ element }">
              <div
                :data-id="element.id"
                class="bg-blue-50 border border-blue-200 rounded p-3 mb-3 shadow-sm"
              >
                <div class="text-blue-800 font-medium">{{ element.title }}</div>
                <div class="mt-2 text-sm text-gray-600">{{ element.description }}</div>
                <div class="mt-3 flex space-x-2">
                  <!-- Only Next button in To Do -->
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
        <div class="flex-1 bg-white rounded-lg shadow p-4 mb-6 md:mb-0" data-status="in_progress">
          <h2 class="text-xl font-semibold text-yellow-600 mb-4 text-center">In Progress</h2>
          <draggable
            v-model="inProgressTasks"
            group="tasks"
            @end="handleDragEnd($event, 'in_progress')"
          >
            <template #item="{ element }">
              <div
                :data-id="element.id"
                class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-3 shadow-sm"
              >
                <div class="text-yellow-800 font-medium">{{ element.title }}</div>
                <div class="mt-2 text-sm text-gray-600">{{ element.description }}</div>
                <div class="mt-3 flex space-x-2">
                  <!-- Previous: Back to Todo -->
                  <button
                    @click="updateTaskStatus(element.id, 'todo')"
                    class="text-sm text-blue-600 hover:underline"
                  >
                    Previous
                  </button>
                  <!-- Next: Move to Done -->
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
        <div class="flex-1 bg-white rounded-lg shadow p-4" data-status="done">
          <h2 class="text-xl font-semibold text-green-600 mb-4 text-center">Done</h2>
          <draggable
            v-model="doneTasks"
            group="tasks"
            @end="handleDragEnd($event, 'done')"
          >
            <template #item="{ element }">
              <div
                :data-id="element.id"
                class="bg-green-50 border border-green-200 rounded p-3 mb-3 shadow-sm"
              >
                <div class="text-green-800 font-medium">{{ element.title }}</div>
                <div class="mt-2 text-sm text-gray-600">{{ element.description }}</div>
                <div class="mt-3 flex space-x-2">
                  <!-- Previous: Back to In Progress -->
                  <button
                    @click="updateTaskStatus(element.id, 'in_progress')"
                    class="text-sm text-yellow-600 hover:underline"
                  >
                    Previous
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
      </div>

      <!-- Task Creation Form -->
      <div class="mt-8 bg-white p-6 rounded-lg shadow max-w-xl mx-auto">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">
          Create New Task
        </h3>
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
            class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
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
    const todoTasks = computed(() =>
      tasks.value.filter((task: any) => task.status === 'todo')
    );
    const inProgressTasks = computed(() =>
      tasks.value.filter((task: any) => task.status === 'in_progress')
    );
    const doneTasks = computed(() =>
      tasks.value.filter((task: any) => task.status === 'done')
    );

    // Reactive new task object
    const newTask = reactive({ title: '', description: '', status: 'todo' });

    // Fetch tasks on component mount
    onMounted(() => store.dispatch('fetchTasks'));

    const createTask = () => {
      store.dispatch('createTasks', { ...newTask });
      newTask.title = '';
      newTask.description = '';
    };

    // Optimistic update then backend sync for task status
    const updateTaskStatus = async (id: number, status: string) => {
      // Optimistically update local state
      const task = tasks.value.find((t: any) => t.id === id);
      if (task) {
        task.status = status;
      }
      // Update on the backend
      await store.dispatch('updateTasks', { id, data: { status } });
      // Re-fetch tasks for consistency
      await store.dispatch('fetchTasks');
    };

    const deleteTask = (id: number) => {
      store.dispatch('deleteTasks', id);
    };

    const handleDragEnd = async (event: any, newStatus: string) => {
      console.log('Drag ended', event, 'newStatus:', newStatus);
      const taskId = event.item.getAttribute('data-id');
      console.log('Dragged task id:', taskId);
      if (taskId) {
        const task = tasks.value.find((t: any) => t.id === Number(taskId));
        if (task && task.status !== newStatus) {
          console.log(`Updating task ${task.id} from status ${task.status} to ${newStatus}`);
          await updateTaskStatus(task.id, newStatus);
        }
      }
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
      handleDragEnd,
    };
  },
});
</script>

<style scoped>
/* Additional custom styles can be added here */
</style>
