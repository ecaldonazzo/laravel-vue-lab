import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import About from '../pages/About.vue'

const routes = [
  { path: '/', component: Home },
  { path: '/sobre', component: About },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})