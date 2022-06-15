<script setup>
import { ref, watchEffect, onMounted } from "vue";
import { countriesStack } from "./../../components/countries";
import { genresStack } from "./../../components/genres";
import { notyf } from "./../../components/noytf";
import Datepicker from "vuejs3-datepicker";
import moment from "moment";
import { useRouter, useRoute } from "vue-router";
const countries = ref(countriesStack);
const genres = ref(genresStack);
const notif = notyf;
const validationErrors = ref([]);
const isLoading = ref(false);
const router = useRouter();
const route = useRoute();

notif.dismissAll();

// main film object
const film = ref([]);

onMounted( async () => {
  await $http.get("films/" + route.params.slug + '/edit').then((response) => {
    film.value = response.data.data;
  });
})

// handling files
const fileAdded = (e) => {
  e.preventDefault();
  const file = e.target.files[0];
  film.value.photo = e.target.files[0];
  film.value.photoSrc = URL.createObjectURL(file);
};
const remvoePicture = (e) => {
  film.value.photo = null;
  film.value.photoSrc = null;
  let input = document.getElementById("staticPhoto");
  input.type = "text";
  input.type = "file";
};

const handleFilm = async (e) => {
  e.preventDefault();
  const URL = `films/`+route.params.slug;
  notif.dismissAll();
  isLoading.value = !isLoading.value;
  let formData = new FormData();
  for (var key in film.value) {
    formData.append(key, film.value[key]);
  }
  formData.append('_method', 'PUT');
  console.log(formData)
  await axios
    .post(URL, formData)
    .then((response) => {
      isLoading.value = !isLoading.value;
      notif.success("Updated Successfully!");
      router.push({
        name: "films",
      });
    })
    .catch((error) => {
      isLoading.value = !isLoading.value;
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
  waitAndScroll();
};

const waitAndScroll = _.debounce(function () {
  const items = document.getElementsByClassName("is-invalid");
  if (items.length > 0) {
    items[0].scrollIntoView({
      behavior: "smooth",
      block: "center",
      inline: "center",
    });
  }
}, 100);

watchEffect(() => {
  if (film.value.release_date != "") {
    film.value.release_date = moment(new Date(film.value.release_date)).format(
      "YYYY-MM-DD"
    );
  } else {
    film.value.release_date = "";
  }
});
</script>

<template>
  <div class="text-left pt-5 pl-4 pb-0">
    <h2>Edit Film {{ film.name }}</h2>
  </div>
  <div class="form-group row mb-4 mt-5 bg-white p-4">
    <label for="staticName" class="col-sm-2 col-form-label">Film Name:</label>
    <div class="col-sm-6">
      <input
        tabindex="1"
        v-model="film.name"
        type="text"
        id="staticName"
        class="input form-control"
        :class="{ 'is-invalid': validationErrors.name }"
      />
      <p v-if="validationErrors.name" class="text-danger">
        {{ validationErrors.name[0] }}
      </p>
    </div>
  </div>
  <div class="form-group row mb-4 mt-5 bg-white p-4">
    <label for="staticDescription" class="col-sm-2 col-form-label"
      >Description:</label
    >
    <div class="col-sm-6">
      <textarea
        tabindex="2"
        v-model="film.description"
        type="text"
        id="staticDescription"
        class="input form-control"
        :class="{ 'is-invalid': validationErrors.description }"
      ></textarea>
      <p v-if="validationErrors.description" class="text-danger">
        {{ validationErrors.description[0] }}
      </p>
    </div>
  </div>

  <div class="form-group row mb-4 mt-5 bg-white p-4">
    <label for="staticReleaseDate" class="col-sm-2 col-form-label"
      >Release Date:</label
    >
    <div class="col-sm-6">
      <datepicker
        :tabindex="'3'"
        @input="(e) => (film.release_date = e)"
        v-model="film.release_date"
        name="uniquename"
        id="staticReleaseDate"
        :class="{ 'is-invalid': validationErrors.release_date }"
      ></datepicker>
      <p v-if="validationErrors.release_date" class="text-danger">
        {{ validationErrors.release_date[0] }}
      </p>
    </div>
  </div>
  <div class="form-group row mb-4 mt-5 bg-white p-4">
    <label for="staticRatings" class="col-sm-2 col-form-label">Ratings:</label>
    <div class="col-sm-6">
      <star-rating
        :tabindex="'4'"
        :show-rating="false"
        :name="'rating'"
        :id="'staticRatings'"
        v-model:rating="film.rating"
        :increment="0.5"
        :class="{ 'is-invalid': validationErrors.rating }"
      ></star-rating>
      <p v-if="validationErrors.rating" class="text-danger mt-2">
        {{ validationErrors.rating[0] }}
      </p>
    </div>
  </div>
  <div class="form-group row mb-4 mt-5 bg-white p-4">
    <label for="staticTicketPrice" class="col-sm-2 col-form-label"
      >Ticket Price:</label
    >
    <div class="col-sm-6">
      <input
        tabindex="5"
        v-model="film.ticket_price"
        type="text"
        class="form-control"
        id="staticTicketPrice"
        placeholder="Ticket Price"
        :class="{ 'is-invalid': validationErrors.ticket_price }"
      />
      <p v-if="validationErrors.ticket_price" class="text-danger mt-2">
        {{ validationErrors.ticket_price[0] }}
      </p>
    </div>
  </div>
  <div class="form-group row mb-4 mt-5 bg-white p-4">
    <label for="staticCountry" class="col-sm-2 col-form-label">Country:</label>
    <div class="col-sm-6">
      <Multiselect
        :tabindex="'6'"
        placeholder="Select Country"
        :options="countries"
        v-model="film.country"
        :searchable="true"
        class="multiselect-green"
        :id="'staticCountry'"
        :class="{ 'is-invalid': validationErrors.country }"
      />
      <p v-if="validationErrors.country" class="text-danger mt-2">
        {{ validationErrors.country[0] }}
      </p>
    </div>
  </div>
  <div class="form-group row mb-4 mt-5 bg-white p-4">
    <label for="staticGenre" class="col-sm-2 col-form-label">Genre:</label>
    <div class="col-sm-6">
      <Multiselect
        :tabindex="'7'"
        placeholder="Select Genre"
        :groupSelect="false"
        :options="genres"
        :groups="true"
        v-model="film.genre"
        :mode="'tags'"
        :searchable="true"
        class="multiselect-green staticGenre"
        :id="'staticGenre'"
        :class="{ 'is-invalid': validationErrors.genre }"
      />
      <p v-if="validationErrors.genre" class="text-danger mt-2">
        {{ validationErrors.genre[0] }}
      </p>
    </div>
  </div>
  <div class="form-group row mb-4 mt-5 bg-white p-4">
    <label for="staticPhoto" class="col-sm-2 col-form-label">Photo:</label>
    <div class="col-sm-6">
      <input
        tabindex="8"
        type="file"
        id="staticPhoto"
        accept="image/*"
        class="form-control pl-0 border-0"
        @change="fileAdded"
      />
      <p v-if="validationErrors.photo" class="text-danger mt-2">
        {{ validationErrors.photo[0] }}
      </p>
    </div>
    <div class="col-sm-3 offset-sm-1" v-if="film.photoSrc">
      <div>
        <img
          :src="film.photoSrc"
          alt="Film Picture"
          :title="film.name"
          style="position: relative; width: 50%"
        />
      </div>
      <span @click="remvoePicture" class="text-danger" style="cursor: pointer"
        >Remove Photo</span
      >
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-8 ml-3 mb-3">
      <button
        type="button"
        class="btn btn-primary"
        @click="handleFilm"
        :disabled="isLoading"
      >
        Update Film
      </button>
      <div class="mt-2" v-if="isLoading" style="display: inline">
        <div class="p-2 spinner-grow text-success" role="status">
          <span class="sr-only">Loading...</span>
        </div>
        <div class="p-2 spinner-grow text-danger" role="status">
          <span class="sr-only">Loading...</span>
        </div>
        <div class="p-2 spinner-grow text-warning" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.is-invalid .vuejs3-datepicker__value {
  border-color: #dc3545 !important;
}
.is-invalid #staticCountry,
.staticGenre.is-invalid {
  border: 1px solid #dc3545 !important;
}
.vuejs3-datepicker__value {
  min-width: 100% !important;
  width: 100% !important;
  border: 1px solid #ced4da !important;
}
</style>
<style scoped>
.vuejs3-datepicker.vuejs3-green {
  width: 100% !important;
}
</style>
