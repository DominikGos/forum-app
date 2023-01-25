const modal = {
  state: () => {
    return {
      open: false
    }
  },
  mutations: {
    closeModal(state) {
      state.open = false
    },
    openModal(state) {
      state.open = true
    },
  }
}

export default modal
