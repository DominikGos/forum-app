const user = {
  state: () => {
    return {
      id: null,
      userName: null,
      firstName: null,
      lastName: null,
      email: null,
      avatar: null,
      token: null,
      timestamps: {
        createdAt: null,
        updatedAt: null,
      }
    }
  },
  mutations: {
    updateUser(state, user) {
      for(const property in state) {
        state[property] = user[property]
      }
    }
  }
}

export default user
