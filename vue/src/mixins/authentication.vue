<script>
import axios from "axios";

export default {
  name: "authentication",
  data() {
    return {
      user: {
        userName: null,
        firstName: null,
        lastName: null,
        email: null,
        password: null,
      },
      errors: {
        userName: [],
        email: [],
        firstName: [],
        lastName: [],
        password: [],
      },
    };
  },
  methods: {
    redirect(to = "home") {
      this.$router.push({ name: to });
    },

    setTokenAsDefault(token) {
      axios.defaults.headers.common["Authorization"] = token;
    },

    setUser(user, token) {
      this.$store.commit("updateUser", {
        ...this.$store.state.user,
        ...user,
        ...{
          userName: user.login,
          token: token,
        },
      });
    },

    setErrors(errors) {
      let errorStructure = {
        userName: [],
        email: [],
        firstName: [],
        lastName: [],
        password: [],
      };

      for (const field in errors) {
        switch (field) {
          case "login":
            errorStructure.userName = errorStructure.userName.concat(errors[field]);
            break;
          case "email":
            errorStructure.email = errorStructure.email.concat(errors[field]);
            break;
          case "first_name":
            errorStructure.firstName = errorStructure.firstName.concat(errors[field]);
            break;
          case "last_name":
            errorStructure.lastName = errorStructure.lastName.concat(errors[field]);
          case "password":
            errorStructure.password = errorStructure.password.concat(errors[field]);
            break;
        }
      }

      return errorStructure;
    },
  },
};
</script>
