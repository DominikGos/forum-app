import { createRouter, createWebHistory } from 'vue-router'
import home from '../views/home.vue'
import threadList from '../views/thread/thread-list.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: home
    },
    {
      path: '/thread/list',
      name: 'threadList',
      component: threadList
    },
  ]
})

export default router
