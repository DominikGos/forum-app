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
      errors: {
        login: [],
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
        ...user,
        ...{
          token: token,
        },
      });

      console.log(this.$store.state.user)
    },

    setErrors(errors) {
      let errorStructure = {
        login: [],
        email: [],
        firstName: [],
        lastName: [],
        password: [],
      };

      for (const field in errors) {
        switch (field) {
          case "login":
            errorStructure.login = errorStructure.login.concat(errors[field]);
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
