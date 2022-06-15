<script setup>
import { ref, watchEffect } from "vue";
import { RouterLink, RouterView, useRouter, useRoute } from "vue-router";
import { useUserSession } from "../../stores";
import { notyf } from "./../../components/noytf";
const router = useRouter();
const route = useRoute();
const userSession = useUserSession();
const notif = notyf;

const name = ref("");
const email = ref("");
const password = ref("");
const password_confirmation = ref("");
const validationErrors = ref([]);
const register = async () => {
  let data = {
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
  };
  await $http
    .post("register", data)
    .then((result) => {
      notif.success("Register Successfully! Please login yourself now.");
      router.push({
        name: "Login",
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
};

const setErrors = (errors) => {
  let settErrors = errors;
  validationErrors.value = settErrors;
};
</script>
<template>
  <div class="card mb-5 mx-auto" style="width: 40rem">
    <div class="card-body">
      <h1 class="">Register Here</h1>
      <div class="form-group row mb-5 mt-5">
        <label for="name" class="col-sm-2"
          ><strong>Name</strong></label
        >
        <input
          class="form-control input-lg col-sm-6"
          type="text"
          v-model="name"
          id="name"
          placeholder="Name"
          :class="{ 'is-invalid': validationErrors.name }"
        />
        <p v-if="validationErrors.name" class="text-danger col-sm-6">
          {{ validationErrors.name[0] }}
        </p>
      </div>
      <div class="form-group row mb-5">
        <label for="email" class="col-sm-2"
          ><strong>Email</strong></label
        >
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
        <label for="password" class="col-sm-2"
          ><strong>Password</strong></label
        >
        <input
          class="form-control input-lg col-sm-4 mr-2"
          type="password"
          v-model="password"
          id="password"
          placeholder="Password"
          :class="{ 'is-invalid': validationErrors.password }"
        />
        <input
          class="form-control input-lg col-sm-4"
          type="password"
          v-model="password_confirmation"
          id="confirm_password"
          placeholder="Confirm Password"
          :class="{ 'is-invalid': validationErrors.password }"
        />
        <p v-if="validationErrors.password" class="text-danger col-sm-6">
          {{ validationErrors.password[0] }}
        </p>
      </div>
      
        <button class="btn btn-primary mb-4" @click="register">
          Register
        </button>
        <br />
        <span>Already have an account?</span>
        <a
          href="javascript:;"
          class="btn-link"
          role="button"
          @click="router.push('/login')"
        >
          Login yourself here</a
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