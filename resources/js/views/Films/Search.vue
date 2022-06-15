<script setup>
import { onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useFilmsObject } from "../../stores";

const filmsObject = useFilmsObject();
const route = useRoute();
const router = useRouter();

onMounted(async () => {
  if(route.params.search) {
    await $http.get("films/search/"+ route.params.search).then((response) => {
      filmsObject.setFilms(response.data.data)
      router.push({
        name: "Result",
      });
    });
  }
});
</script>

<template>
</template>