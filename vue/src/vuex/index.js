import { createStore } from 'vuex'
import modal from './modules/modal.js'
import user from './modules/user.js'

const store = createStore({
  modules: {
    user, 
    modal,
  }
})

export { store }
