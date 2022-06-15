<script setup>
import { onMounted, ref } from "vue";
import { RouterLink, RouterView, useRouter, useRoute } from "vue-router";
import { useUserSession } from "../../stores";
import { notyf } from "./../../components/noytf";
import moment from "moment";
import Swal from "sweetalert2";

const userSession = useUserSession();
const route = useRoute();
const films = ref([]);
const notif = notyf;

const truncateDescription = (str, no_words) => {
  let words = str.split(" ");
  return words.length >= no_words
    ? str.split(" ").splice(0, no_words).join(" ")
    : str;
};

const deleteFilm = async (slug, i) => {
  Swal.fire({
    title: "Are you sure you want to delete this film?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then(async (result) => {
    if (result.isConfirmed) {
      await $http.delete("films/" + slug).then((response) => {
        notif.success("Deleted Successfully!");
        films.value.splice(i, 1);
      });
    }
  });
};

onMounted(async () => {
  await $http.get("films").then((response) => {
    films.value = response.data.data;
  });
});
</script>

<template>
  <div class="text-center pt-3 pr-4 pb-3">
    <h2>Films List</h2>
  </div>
  <div class="d-inline mb-5" v-if="!films.length">
    <img
      class="img-responsive"
      style="width: 100%"
      :src="'/images/no_records.png'"
      alt="Card image cap"
    />
  </div>
  <template v-for="(film, i) in films" :key="i">
    <div class="d-inline mb-5" v-if="films.length">
      <div
        class="card d-inline-flex m-3 mb-5"
        style="width: 20rem; vertical-align: top"
      >
        <router-link
          :to="{ name: 'ShowFilm', params: { slug: film.slug } }"
          class="link"
        >
          <img
            class="card-img-top"
            :src="film.photoSrc ? film.photoSrc : '/images/placeholder.png'"
            alt="Film Image"
          />
        </router-link>
        <div class="card-body">
          <router-link
            :to="{ name: 'ShowFilm', params: { slug: film.slug } }"
            class="btn text-left m-0 p-0"
          >
            <h5 class="card-title">{{ film.name }}</h5>
          </router-link>
          <div class="d-inline float-right">
            <router-link
              :to="{ name: 'EditFilm', params: { slug: film.slug } }"
              class="btn text-left m-0 p-0"
            >
              <span class="action text-primary mr-1 faedit"
                ><i class="fa fa-edit"></i
              ></span>
            </router-link>
            <span
              @click="deleteFilm(film.slug, i)"
              class="float-right action text-danger"
              ><i class="fa fa-trash"></i
            ></span>
          </div>
          <p class="card-text-1">
            {{ truncateDescription(film.description, 10) }}
            <span class="badge badge-light">
              <router-link
                :to="{ name: 'ShowFilm', params: { slug: film.slug } }"
                class="m-0 p-0"
                >Read More</router-link
              ></span
            >
          </p>
          <div class="row">
            <div class="col-sm-4">
              <p class="card-text mb-0">
                <small class="text-muted">Rating</small>
                <small class="text-muted ml-1">{{ film.rating }}</small>
              </p>
              <star-rating
                :star-size="15"
                :show-rating="false"
                :name="'rating'"
                :active-color="'#ff9f1a'"
                :id="'staticRatings'"
                :title="film.rating"
                :read-only="true"
                v-model:rating="film.rating"
                :hover:rating="true"
                :increment="0.5"
              ></star-rating>
            </div>
            <div class="col-sm-4">
              <p class="card-text mb-0">
                <small class="text-muted">Ticket Price</small>
              </p>
              <p class="card-text mb-0">
                <small class="price">${{ film.ticket_price }}</small>
              </p>
            </div>
            <div class="col-sm-4">
              <p class="card-text mb-0">
                <small class="text-muted">Country</small>
              </p>
              <p class="card-text mb-0">
                <small class="country">{{ film.country }}</small>
              </p>
            </div>
          </div>
          <div class="row">
            <div class="mt-3 ml-4">Genre:</div>
            <div class="col-sm-12 mt-2">
              <template v-if="Array.isArray(film.genre)">
                <span
                  class="badge badge-light p-2 mb-2 ml-1"
                  v-for="(genre, index) in film.genre"
                  :key="index"
                  >{{ genre }}</span
                >
              </template>
              <template v-else>
                <span class="badge badge-light p-2 mb-2 ml-1">{{
                  film.genre
                }}</span>
              </template>
            </div>
          </div>

          <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
        </div>
      </div>
    </div>
  </template>
  <div class="mb-5"></div>
</template>
<style scoped>
.router {
  vertical-align: top;
}
.card-img-top {
  width: 100%;
  height: 15vw;
  object-fit: cover;
}
.card-text-1 {
  height: 6vw;
  /* height: auto; */
}
.price {
  color: #ff9f1a;
}
.country {
  color: #85ad00;
}
.badge-light {
  color: #ff9f1a;
}
.faedit {
  margin-top: 1.1px !important;
}
.action {
  cursor: pointer;
}
</style>