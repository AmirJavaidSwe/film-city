import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'

export const useUserSession = defineStore('userSession', () => {
  const user = useStorage('user', '')

  const isLoggedIn = computed(
    () => user.value !== undefined && user.value !== ''
  )

  function setUser(newUser) {
    user.value = JSON.stringify(newUser)
  }

  function getUser() {
    return JSON.parse(user.value)
  }

  async function logoutUser() {
    user.value = undefined
  }

  return {
    user,
    isLoggedIn,
    logoutUser,
    setUser,
    getUser,
  }
})
export const useFilmsObject = defineStore('filmsObject', () => {
  const films = useStorage('films', [])

  function setFilms(data) {
    films.value = JSON.stringify(data)
  }

  function getFilms() {
    return JSON.parse(films.value)
  }

  return {
    films,
    setFilms,
    getFilms,
  }
})
