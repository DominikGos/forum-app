import { createRouter, createWebHistory } from 'vue-router'
import appLayout from '../layouts/app-layout.vue'
import authLayout from '../layouts/auth-layout.vue'
import home from '../views/home.vue'
import forums from '../views/forum/forums.vue'
import forum from '../views/forum/forum.vue'
import forumCreate from '../views/forum/forum-create.vue';
import thread from '../views/thread/thread.vue'
import login from '../views/auth/login.vue'
import register from '../views/auth/register.vue'
import user from '../views/user/user.vue'
import userData from '../views/user/user-data.vue'
import userReplies from '../views/user/user-replies.vue'
import userThreads from '../views/user/user-threads.vue'
import userEdit from '../views/user/user-edit.vue'

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
          path: 'forums/create',
          name: 'forumCreate',
          component: forumCreate,
          meta: {
            requiresAuth: true,
          }
        },
        {
          path: 'forums/:id/threads/:threadId',
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
            {
              path: 'edit',
              name: 'userEdit',
              component: userEdit,
              meta: {
                requiresAuth: true
              }
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
  else if (to.meta.requiresAuth && store.state.user.token == null) {
    return {
      name: 'login',
      query: { redirect: to.fullPath },
    }
  }
})

export default router
