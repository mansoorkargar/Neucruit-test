import { createWebHistory, createRouter } from "vue-router";
import store from "../store";

import { routes as AuthRoutes } from "./auth";
import { routes as UserRoutes } from "./user";
import { routes as AdminRoutes } from "./admin";
import { routes as LandingPage } from "./landingPage";

export const routes = AuthRoutes.concat(UserRoutes, AdminRoutes, LandingPage);

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    linkExactActiveClass: "active"
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (store.getters.authToken ? true : false) {
            // if (!store.getters.study && to.name !== 'SelectStudy') {
            //     next({ name: "SelectStudy" });
            //     return;
            // }

            next();
            return;
        } else if (to.name == 'Registration' && store.getters.user) {
            next();
            return;
        }

        next({ name: "Login" });
    } else {
        if (!store.getters.authToken) {
            next();
            return;
        }

        next({ name: "Home" });
    }
});

export default router;
