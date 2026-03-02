import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import About from '../pages/About.vue'
import Pokemon from "../pages/Pokemon.vue";

const routes = [
    { path: '/', component: Home },
    { path: '/sobre', component: About },
    { path: '/chat', component: Home },
    { path: '/pokemon', component: Pokemon }
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
