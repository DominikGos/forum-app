import { createRouter, createWebHistory } from 'vue-router'
import appLayout from '../layouts/app-layout.vue'
import authLayout from '../layouts/auth-layout.vue'
import home from '../views/home.vue'
import forums from '../views/forum/forums.vue'
import forum from '../views/forum/forum.vue'
import thread from '../views/thread/thread.vue'
import login from '../views/auth/login.vue'
import register from '../views/auth/register.vue'
import user from '../views/user/user.vue'
import userData from '../views/user/user-data.vue'
import userReplies from '../views/user/user-replies.vue'
import userThreads from '../views/user/user-threads.vue'
import { store } from '../vuex'

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
          path: 'forums/:id',
          name: 'forum',
          component: forum
        },
        {
          path: 'forums',
          name: 'forums',
          component: forums
        },
        {
          path: 'threads/:id',
          name: 'thread',
          component: thread
        },
        {
          path: 'users/:id',
          component: user,
          children: [
            {
              path: '',
              name: 'user',
              component: userData
            },
            {
              path: 'replies',
              name: 'userReplies',
              component: userReplies
            },
            {
              path: 'threads',
              name: 'userThreads',
              component: userThreads
            },
          ]
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
          component: login,
          meta: {
            requiresNoAuth: true
          }
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
          component: register,
          meta: {
            requiresNoAuth: true
          }
        }
      ]
    },
  ]
})

router.beforeEach((to, from) => {
  if (to.meta.requiresNoAuth && store.state.user.token) {
    return {
      name: 'home',
      query: { redirect: to.fullPath },
    }
  }
})

export default router
