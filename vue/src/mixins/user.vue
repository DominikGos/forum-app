<script>
import axios from 'axios';

export default {
  name: 'user',
  data() {
    return {
      user: {},
      defaultPhoto: '/public/images/user.png',
    }
  },
  methods: {
    async setUser(id) {
      this.user = await this.fetchUser(id)
    },
    async fetchUser(id) {
      try {
        const response = await axios.get(`users/${id}`)

        return response.data.user
      } catch (error) {
        return null
      }
    },
    saveUserInStorage() {
      const user = JSON.stringify(this.$store.state.user)

      localStorage.setItem('user', user)
    },
    saveUserInVuex(user, token) {
      this.$store.commit("updateUser", {
        ...user,
        ...{
          token: token,
        },
      });
    },
  },
}
</script>
