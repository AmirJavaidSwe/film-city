<script setup>
import { ref, watchEffect } from "vue";
import { RouterLink, RouterView, useRouter, useRoute } from "vue-router";
const router = useRouter();
const route = useRoute();
import { useUserSession } from "./stores";
const userSession = useUserSession();
const search = ref("");
const searchError = ref("");
const searchMovie = () => {
  if (!search.value) {
    searchError.value = 'Please type something in the input first.'
  }
  if (search.value) {
    searchError.value = ''
    router.push({
      name: "Search",
      params: { search: search.value },
    });
  }
};
const logout = () => {
  $http.post('logout', {}).then((result) => {
    userSession.logoutUser()
  }).catch((err) => {
    
  });
};
</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <router-link :to="{ path: '/' }" class="navbar-brand">
      Film City
    </router-link>
    <!-- <a class="navbar-brand" href="#">{{ 'Film City' }}</a> -->
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <router-link
            :to="{ path: '/' }"
            class="nav-link"
            :class="$route.path == '/films' ? 'active' : ''"
          >
            Home
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
            :to="{ name: 'CreateFilm' }"
            class="nav-link"
            :class="$route.path == '/films/crete' ? 'active' : ''"
          >
            Add New Film
          </router-link>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" @submit.prevent="searchMovie">
        <input
          class="form-control mr-sm-2"
          type="search"
          v-model="search"
          title="Search Film by name, rating, price, country or genre"
          placeholder="Search Film by name, rating, price, country or genre"
          aria-label="Search"
          :class="{ 'is-invalid': searchError }"
        />
        <button
          class="btn btn-outline-success my-2 my-sm-0"
          type="button"
          @click="searchMovie"
        >
          Search
        </button>
      </form>
      <ul class="navbar-nav" v-if="!userSession.isLoggedIn">
        <li class="nav-item">
          <router-link
            :to="{ name: 'Login' }"
            class="nav-link"
            :class="$route.path == '/login' ? 'active' : ''"
          >
            Login
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
            :to="{ name: 'Signup' }"
            class="nav-link"
            :class="$route.path == '/login' ? 'active' : ''"
          >
            Signup
          </router-link>
        </li>
      </ul>
      <ul class="navbar-nav" v-if="userSession.isLoggedIn">
        <li class="nav-item mr-2 ml-3 text-danger btn" @click="logout">
            Logout
        </li>
        <li class="nav-item">
          <span>
            Logged In As: 
          </span>
          <br />
          <span class="text-danger">
          {{ userSession.getUser().name }}
          </span>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container mt-5">
    <RouterView />
  </div>
</template>
<style scoped>
.container {
  padding: 0 !important;
  background: #eee !important;
  /* margin: 0 !important; */
}
</style>