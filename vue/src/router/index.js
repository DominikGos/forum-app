import { createRouter, createWebHistory } from 'vue-router'
import home from '../views/home.vue'
import forum from '../views/forum.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: home
    },
    {
      path: '/forum',
      name: 'forum',
      component: forum
    },
  ]
})

export default router
