const modal = {
  state: () => {
    return {
      open: false,
      componentName: ''
    }
  },
  mutations: {
    closeModal(state) {
      state.open = false
    },
    openModal(state) {
      state.open = true
    },
    updateComponentName(state, componet) {
      state.componentName = componet.name
    }
  }
}

export default modal
