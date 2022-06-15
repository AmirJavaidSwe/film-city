<script setup>
import { onMounted, ref } from "vue";
import { RouterLink, RouterView, useRouter, useRoute } from "vue-router";
import { useUserSession } from "./../../stores";
import { notyf } from "./../../components/noytf";
import moment from "moment";
import Swal from "sweetalert2";
const userSession = useUserSession();
const route = useRoute();
const router = useRouter();
const film = ref([]);
const comment = ref("");
const commentReply = ref([]);
const commentError = ref("");
const commentReplyError = ref([]);
const notif = notyf;
notif.dismissAll();

onMounted(async () => {
  await $http.get("films/" + route.params.slug).then((response) => {
    film.value = response.data.data;
  });
});

const deleteFilm = async () => {
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
      await $http.delete("films/" + route.params.slug).then((response) => {
        notif.success("Deleted Successfully!");
        router.push({
          name: "films",
        });
      });
    }
  });
};
const postComment = async () => {
  if (comment.value) {
    commentError.value = "";
    await $http
      .post("comment", {
        comment: comment.value,
        film_id: film.value.id,
      })
      .then((response) => {
        film.value.comments.push(response.data.data);
        comment.value = "";
        console.log(film.value.comments);
      });
  } else {
    commentError.value = "Please write a comment first";
  }
};
const postCommentsReply = async (index, id) => {
  if (commentReply.value[index]) {
    commentReplyError.value[index] = "";
    await $http
      .post("comment/reply", {
        comment_id: id,
        comment: commentReply.value[index],
        film_id: film.value.id,
      })
      .then((response) => {
        film.value.comments.splice(index, 1, response.data.data);
        commentReply.value[index] = "";
      });
  } else {
    commentReplyError.value[index] = "Please write a comment first";
  }
};

const showReplyBox = (index) => {
  if (!film.value.comments[index].is_reply_box_open) {
    commentReplyError.value[index] = "";
    film.value.comments[index].is_reply_box_open = true;
  }
};
</script>

<template>
  <div class="card">
    <div class="container-fliud">
      <div class="wrapper row">
        <div class="preview col-md-6">
          <div class="preview-pic tab-content">
            <div class="tab-pane active" id="pic-1">
              <img :src="film.photoSrc" />
            </div>
          </div>
        </div>
        <div class="details col-md-6">
          <h3 class="product-title">
            {{ film.name }}
            <div class="d-inline">
              <span @click="deleteFilm" class="float-right text-danger action"
                ><i class="fa fa-trash"></i></span
              >&nbsp;
              <router-link
                :to="{ name: 'EditFilm', params: { slug: route.params.slug } }"
                class=""
              >
                <span class="text-primary action faedit mr-1 float-right"
                  ><i class="fa fa-edit"></i
                ></span>
              </router-link>
            </div>
          </h3>
          <div class="rating">
            <star-rating
              :star-size="20"
              :active-color="'#ff9f1a'"
              :show-rating="false"
              :name="'rating'"
              :id="'staticRatings'"
              :title="film.rating"
              :read-only="true"
              v-model:rating="film.rating"
              :hover:rating="true"
              :increment="0.5"
            ></star-rating>
          </div>
          <p class="product-description">{{ film.description }}</p>
          <h4 class="price">
            Ticket Price: <span>${{ film.ticket_price }}</span>
          </h4>
          <h6 class="sizes">
            Genre:
            <template v-if="Array.isArray(film.genre)">
              <span
                class="size badge"
                v-for="(genre, index) in film.genre"
                :key="index"
                >{{ genre }}</span
              >
            </template>
            <template v-else>
              <span
                class="size badge badge-light p-2 mb-2 ml-1"
                v-for="(genre, index) in film.genre"
                :key="index"
                >{{ film.genre }}</span
              >
            </template>
          </h6>
          <h6 class="sizes">
            Release Date:
            <span class="size badge">{{
              moment(film.release_date).format("DD-MMM-YYYY")
            }}</span>
          </h6>
          <h6 class="sizes">
            Country:
            <span class="size badge">{{ film.country }}</span>
          </h6>
        </div>
      </div>
      <div class="card p-0">
        <div class="card-body pb-0">
          <h5 class="card-title">Comments</h5>
          <h6
            class="card-subtitle mb-2 text-muted"
            v-if="!userSession.isLoggedIn"
          >
            You need to login first.
          </h6>
        </div>
        <div class="card-body" v-if="userSession.isLoggedIn">
          <template v-if="film.comments">
            <div
              class="card-body pb-3 bg-white m-1 mb-2"
              v-for="(comment, ci) in film.comments"
              :key="ci"
            >
              <p class="card-text">
                <strong>{{ comment.user.name }}</strong>
              </p>
              <p class="card-text">
                {{ comment.comment }}
              </p>
              <template v-if="comment.childs">
                <div class="card-body pb-3 bg-white m-1 mb-2" v-for="(reply, rci) in comment.childs" :key="rci">
                  <p class="card-text">
                    <strong>{{ reply.user.name }}</strong>
                  </p>
                  <p class="card-text">
                    {{ reply.comment }}
                  </p>
                </div>
              </template>
              <p class="card-text pl-5" v-if="comment.is_reply_box_open">
                <textarea
                  v-if="comment.is_reply_box_open"
                  class="form-control"
                  cols="20"
                  rows="4"
                  v-model="commentReply[ci]"
                ></textarea>
                  <p class="text-danger" v-show="commentReplyError[ci]">{{ commentReplyError[ci] }}</p>
                <button
                  type="button"
                  @click="postCommentsReply(ci, comment.id)"
                  class="btn btn-primary mt-2 mr-1"
                >
                  Post Reply
                </button>
                <span
                  class="btn link text-danger p-0"
                  @click="comment.is_reply_box_open = false"
                  >Cancel</span
                >
              </p>
              <span v-if="!comment.is_reply_box_open"
                class="btn link text-primary p-0"
                @click="showReplyBox(ci, true)"
                >Reply</span
              >
            </div>
          </template>
        </div>
        <div class="card-body" v-if="userSession.isLoggedIn">
          <h5 class="card-title">Add a Comment</h5>
          <h6
            class="card-subtitle mb-2 text-muted"
            v-if="!userSession.isLoggedIn"
          >
            You need to login first.
          </h6>
          <textarea
            class="form-control"
            v-model="comment"
            cols="30"
            rows="4"
          ></textarea>
          <p class="text-danger" v-show="commentError">{{ commentError }}</p>
          <button
            type="button"
            @click="postComment"
            class="btn btn-primary mt-2"
          >
            Post Comment
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="mb-5"></div>
</template>

<style scoped>
/*****************globals*************/
body {
  font-family: "open sans";
  overflow-x: hidden;
}

img {
  max-width: 100%;
}

.preview-pic {
  height: auto;
  max-height: 35vw;
}
.preview {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
  -ms-flex-direction: column;
  flex-direction: column;
}
@media screen and (max-width: 996px) {
  .preview {
    margin-bottom: 20px;
  }
}

.preview-pic {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
  -ms-flex-positive: 1;
  flex-grow: 1;
}

.preview-thumbnail.nav-tabs {
  border: none;
  margin-top: 15px;
}
.preview-thumbnail.nav-tabs li {
  width: 18%;
  margin-right: 2.5%;
}
.preview-thumbnail.nav-tabs li img {
  max-width: 100%;
  display: block;
}
.preview-thumbnail.nav-tabs li a {
  padding: 0;
  margin: 0;
}
.preview-thumbnail.nav-tabs li:last-of-type {
  margin-right: 0;
}

.tab-content {
  overflow: hidden;
}
.tab-content img {
  width: 100%;
  -webkit-animation-name: opacity;
  animation-name: opacity;
  -webkit-animation-duration: 0.3s;
  animation-duration: 0.3s;
}

.card {
  margin-top: 50px;
  background: #eee;
  padding: 3em;
  line-height: 1.5em;
}

@media screen and (min-width: 997px) {
  .wrapper {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
  }
}

.details {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
  -ms-flex-direction: column;
  flex-direction: column;
}

.colors {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
  -ms-flex-positive: 1;
  flex-grow: 1;
}

.product-title,
.price,
.sizes,
.colors {
  text-transform: UPPERCASE;
  font-weight: bold;
}

.checked,
.price span {
  color: #ff9f1a;
}

.product-title,
.rating,
.product-description,
.price,
.vote,
.sizes {
  margin-bottom: 15px;
}

.product-title {
  margin-top: 0;
}

.size {
  margin-right: 10px;
}
.size:first-of-type {
  margin-left: 40px;
}

.color {
  display: inline-block;
  vertical-align: middle;
  margin-right: 10px;
  height: 2em;
  width: 2em;
  border-radius: 2px;
}
.color:first-of-type {
  margin-left: 20px;
}

.add-to-cart,
.like {
  background: #ff9f1a;
  padding: 1.2em 1.5em;
  border: none;
  text-transform: UPPERCASE;
  font-weight: bold;
  color: #fff;
  -webkit-transition: background 0.3s ease;
  transition: background 0.3s ease;
}
.add-to-cart:hover,
.like:hover {
  background: #b36800;
  color: #fff;
}

.not-available {
  text-align: center;
  line-height: 2em;
}
.not-available:before {
  font-family: fontawesome;
  content: "\f00d";
  color: #fff;
}

.orange {
  background: #ff9f1a;
}

.green {
  background: #85ad00;
}

.blue {
  background: #0076ad;
}

.tooltip-inner {
  padding: 1.3em;
}

@-webkit-keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
    transform: scale(3);
  }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
  }
}

@keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
    transform: scale(3);
  }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
  }
}

.faedit {
  margin-top: 1.5px !important;
}
.action {
  cursor: pointer;
}
/*# sourceMappingURL=style.css.map */
</style>