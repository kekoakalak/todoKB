import { createStore } from 'vuex';
import api from '@/services/api';
import router from '@/router';

const token = localStorage.getItem('token');
if (token){
  api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

export default createStore({
  state: {
    token:  token || '',
    user:   null,
    tasks:  [],
  },


  // getters: {

  // },


  mutations: {
    setToken(state, token){
      state.token = token;
      localStorage.setItem('token', token);
      api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    },

    setUser(state,user){
      state.user = user;
    },

    setTasks(state,tasks){
      state.tasks = tasks;
    },

    logout(state){
      state.token = '';
      state.user = null;
      state.tasks = [];
      localStorage.removeItem('token');
      delete api.defaults.headers.common['Authorization'];
    },
  },


  actions: {
    async login({commit}, credentials){
      const response = await api.post('/login', credentials);
      commit ('setToken', response.data.token);
      const userResponse = await api.get('/user');
      commit ('setUser', userResponse.data);
    },

    async register({commit}, userData){
      const response = await api.post('/register', userData);
      commit ('setToken', response.data.token);
      const userResponse = await api.get('/user');
      commit ('setUser', userResponse.data);
      router.push('/login');
    },

    async fetchTasks({commit}){
      const response = await api.get('/tasks');
      commit ('setTasks', response.data);
    },

    async createTasks({dispatch}, taskData){
      await api.post('/tasks', taskData);
      dispatch ('fetchTasks');
    },

    async updateTasks({dispatch}, {id, data}){
      await api.put(`/tasks/${id}`, data);
      dispatch('fetchTasks');
    },

    async deleteTasks({dispatch}, id){
      await api.delete(`/tasks/${id}`);
      dispatch('fetchTasks');
    },

    logout({commit}){
      commit ('logout');
    },

  },

  // modules: {
  // }
})
