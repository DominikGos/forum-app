<script>
import axios from 'axios';

export default {
  name: 'user',
  data() {
    return {
      user: {}
    }
  },
  methods: {
    async setUser(id) {
      const authUser = this.$store.state.user;

      if (id == authUser.id) {
        this.user = authUser;
      } else {
        this.user = await this.fetchUser(id)
      }
    },
    async fetchUser(id) {
      try {
        const response = await axios.get(`users/${id}`)

        return response.data.user
      } catch (error) {
        return null
      }
    }
  },
}
</script>
