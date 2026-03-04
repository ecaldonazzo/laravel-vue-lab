import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import About from '../pages/About.vue'
import Pokemon from '../pages/Pokemon.vue'
import Chat from '../pages/Chat.vue'
import AdminChat from '../pages/AdminChat.vue'

const routes = [
    { path: '/',           component: Home },
    { path: '/sobre',      component: About },
    { path: '/pokemon',    component: Pokemon },
    { path: '/chat',       component: Chat },
    { path: '/admin/chat', component: AdminChat },
]

export default createRouter({
    history: createWebHistory(),
    routes,
})
