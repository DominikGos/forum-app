const user = {
  state: () => {
    return {
      userName: null,
      firstName: null,
      lastName: null,
      email: null,
      password: null,
      token: null
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
