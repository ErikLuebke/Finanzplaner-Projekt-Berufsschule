import { defineStore } from 'pinia'
import axios from '@/api/axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user:  JSON.parse(localStorage.getItem('user') ?? 'null'),
    token: localStorage.getItem('token') || null,
  }),

  getters: {
    isLoggedIn: (state) => !!state.token,
  },

  actions: {
    async register(name, email, password, passwordConfirmation) {
      const { data } = await axios.post('/register', {
        name, email, password, password_confirmation: passwordConfirmation,
      })
      this.setAuth(data)
    },

    async login(email, password) {
      const { data } = await axios.post('/login', { email, password })
      this.setAuth(data)
    },

    async logout() {
      await axios.post('/logout')
      this.clearAuth()
    },

    setAuth({ token, user }) {
      this.token = token
      this.user  = user
      localStorage.setItem('token', token)
      localStorage.setItem('user', JSON.stringify(user))
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    },

    clearAuth() {
      this.token = null
      this.user  = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      delete axios.defaults.headers.common['Authorization']
    },
  },
})