import { createRouter, createWebHistory } from 'vue-router'
import appLayout from '../layouts/app-layout.vue'
import authLayout from '../layouts/auth-layout.vue'
import home from '../views/home.vue'
import forum from '../views/forum.vue'
import threadList from '../views/thread/thread-list.vue'
import thread from '../views/thread/thread.vue'
import login from '../views/auth/login.vue'
import register from '../views/auth/register.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: appLayout,
      children: [
        {
          name: 'home',
          path: '',
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
    },
    {
      path: '/login',
      component: authLayout,
      children: [
        {
          name: 'login',
          path: '',
          component: login
        }
      ]
    },
    {
      path: '/register',
      component: authLayout,
      children: [
        {
          name: 'register',
          path: '',
          component: register
        }
      ]
    },
  ]
})

export default router
