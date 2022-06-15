<script setup>
import { ref, watchEffect } from "vue";
import { RouterLink, RouterView, useRouter, useRoute } from "vue-router";
import { useUserSession } from "../../stores";
import { notyf } from "./../../components/noytf";
const router = useRouter();
const route = useRoute();
const userSession = useUserSession();
const notif = notyf;

const email = ref("");
const password = ref("");
const validationErrors = ref([]);
const login = async () => {
  $http.defaults.baseURL = '';
  await $http.get("/sanctum/csrf-cookie").then(async (response) => {
    let data = {
      email: email.value,
      password: password.value,
    };
    $http.defaults.baseURL = '/api/v1/';
    await $http
      .post("login", data)
      .then((result) => {
        notif.success("Logged In Successfully!");
        router.push({
          name: "films",
        });
      })
      .catch((error) => {
        if (error && error.response.status == 422) {
          const errors = error.response.data.errors;
          setErrors(errors);
          notif.error("Validation Error!");
        }
        if (error && error.response.status != 422) {
          notif.error("Error! " + error.response.data.message);
        }
      });
  });
};

const setErrors = (errors) => {
  console.log(errors)
  validationErrors.value = errors;
};
</script>
<template>
  <div class="card mb-5 mx-auto" style="width: 40rem">
    <div class="card-body">
      <h1 class="">Login Here</h1>

      <div class="form-group row mt-5 mb-5">
        <label for="email" class="col-sm-2"><strong>Email</strong></label>
        <input
          class="form-control input-lg col-sm-6"
          type="email"
          v-model="email"
          id="email"
          placeholder="Email"
          :class="{ 'is-invalid': validationErrors.email }"
        />
        <p v-if="validationErrors.email" class="text-danger col-sm-6">
          {{ validationErrors.email[0] }}
        </p>
      </div>
      <div class="form-group row mb-5">
        <label for="password" class="col-sm-2"><strong>Password</strong></label>
        <input
          class="form-control input-lg col-sm-6"
          type="password"
          v-model="password"
          id="password"
          placeholder="Password"
          :class="{ 'is-invalid': validationErrors.password }"
        />
        <p v-if="validationErrors.password" class="text-danger col-sm-6">
          {{ validationErrors.password[0] }}
        </p>
      </div>

      <button class="btn btn-primary mb-4" @click="login">Login</button>
      <br />
      <span>Don't have an account?</span>
      <a
        href="javascript:;"
        class="btn-link"
        role="button"
        @click="router.push('/signup')"
      >
        Register yourself here</a
      >!
    </div>
  </div>
</template>
<style scoped>
.btn-link:hover {
  color: darkgreen;
}
.btn-link {
  text-decoration: none !important;
}
.card {
  border: 0;
}
</style>