import { createRouter, createWebHistory } from "vue-router";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import Dashboard from "../pages/Dashboard.vue";
import DefaultLayout from "../components/DefaultLayout.vue";
import store from "../store";

const routes = [
  {
    path: '/',
    redirect: '/dashboard',
    name: Dashboard,
    component: DefaultLayout,
    meta: {requiresAuth: true},
    children: [
      {path: '/dashboard', name: 'Dashboard', component: Dashboard},
    ]
  },
  {
    path: '/login',
    component: Login
  },
  {
    path: '/register',
    component: Register
  },
];

const router = createRouter({
  routes,
  history: createWebHistory()
});

// router.beforeEach(() => {
//   if (to.meta.requiresAuth && store.state.user.token) {
//     next({name: 'Login'})
//   } else {
//     next();
//   }
// })

export default router;