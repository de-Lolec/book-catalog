import { createRouter, createWebHistory } from "vue-router";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import Catalog from "../pages/Catalog.vue";
import Dashboard from "../pages/Dashboard.vue";
import DefaultLayout from "../components/DefaultLayout.vue";
import store from "../store";

const routes = [
  {
    path: '/',
    redirect: '/dashboard',
    component: DefaultLayout,
    meta: {requiresAuth: true},
    children: [
      {path: '/dashboard', name: 'Dashboard', component: Dashboard},
    ]
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    component: Register
  },
  {
    path: '/catalog',
    name: 'Catalog',
    component: Catalog
  },
  {
    path: '/catalog/category/:category_id',
    name: 'Category',
    component: Catalog
  },
];

const router = createRouter({
  routes,
  history: createWebHistory()
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({name: 'Login'})
  } else if (store.state.user.token && (to.name === 'Login' || to.name === 'Register')) {
    next({name: 'Dashboard'});
  } else {
    next()
  }
})

export default router;