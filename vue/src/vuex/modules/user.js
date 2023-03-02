const user = {
  state: () => {
    return {
      id: null,
      email: null,
      login: null,
      avatarPath: null,
      firstName: null,
      lastName: null,
      description: null,
      roles: [
        null
      ],
      loggedOutAt: null,
      timestamps: {
        createdAt: null,
        updatedAt: null
      },
      createdForumCount: null,
      threadCount: null,
      replieCount: null,
      token: null,
    }
  },
  mutations: {
    updateUser(state, user) {
      for (const property in state) {
        state[property] = user[property]
      }
    }
  }
}

export default user
