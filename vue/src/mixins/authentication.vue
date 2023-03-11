<script>
import axios from "axios";

export default {
  name: "authentication",
  data() {
    return {
      user: {
        login: null,
        firstName: null,
        lastName: null,
        email: null,
        password: null,
      },
    };
  },
  methods: {
    redirect(to = "home") {
      this.$router.push({ name: to });
    },

    setTokenAsDefault(token) {
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
    },

    logout() {
      axios
        .post("logout")
        .then(response => {
          if(response.status == 200) {
            this.setTokenAsDefault(null)
            this.$store.commit('resetUser')
            this.$router.push({name: 'login'})
          }
        })
        .catch((e) => {});
    },

    setUser(user, token) {
      this.$store.commit("updateUser", {
        ...user,
        ...{
          token: token,
        },
      });
    },
  },
};
</script>
