import { createRouter, createWebHistory } from 'vue-router'
import home from '../views/home.vue'
import forum from '../views/forum.vue'
import threadList from '../views/thread/thread-list.vue'
import thread from '../views/thread/thread.vue'

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
    {
      path: '/threads',
      name: 'threadList',
      component: threadList
    },
    {
      path: '/threads/:id',
      name: 'thread',
      component: thread
    },
  ]
})

export default router
