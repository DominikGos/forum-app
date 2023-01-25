import { createStore } from 'vuex'
import modal from './modules/modal.js'

const store = createStore({
  modules: {
    modal
  }
})

export { store }
