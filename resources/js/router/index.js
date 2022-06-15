import { ref } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import { useUserSession } from "./../stores";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            redirect: "/films"
        },
        {
            path: "/films",
            name: "films",
            component: () => import("./../views/Films/ListFilm"),
            meta: {
                requiresAuth: false,
            },
        },
        {
            path: "/films/create",
            name: "CreateFilm",
            component: () => import("./../views/Films/CreateFilm"),
        },
        {
            path: "/films/:slug",
            name: "ShowFilm",
            component: () => import("./../views/Films/ShowFilm"),
        },
        {
            path: "/films/:slug/edit",
            name: "EditFilm",
            component: () => import("./../views/Films/EditFilm"),
        },
        {
            path: "/films/search/:search",
            name: "Search",
            component: () => import("./../views/Films/Search"),
        },
        {
            path: "/films/search/result",
            name: "Result",
            component: () => import("./../views/Films/Result"),
        },
        {
            path: "/login",
            name: "Login",
            component: () => import("./../views/Auth/Login"),
        },
        {
            path: "/signup",
            name: "Signup",
            component: () => import("./../views/Auth/Register"),
        }
    ],
});

const fetchUser = async () => {
    const userSession = useUserSession();
    return await $http
        .get("me")
        .then((result) => {
            userSession.setUser(result.data);
        })
        .catch((error) => {
            userSession.logoutUser();
        });
};


router.beforeEach(async (to, from, next) => {
    await fetchUser();
    const userSession = useUserSession();
    if (
        to.meta.requiresAuth &&
        (to.name !== "login" || to.name !== "register") &&
        !userSession.isLoggedIn
    )
        next({ name: "login" });
    else if (
        to.meta.requiresAuth &&
        (to.name === "Login" || to.name === "register") &&
        userSession.isLoggedIn
    )
        next({ name: "Home" });
    else next();
});
export default router;
