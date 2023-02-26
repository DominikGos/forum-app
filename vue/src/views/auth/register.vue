<template>
  <form @submit="register($event)" class="d-flex flex-column gap-3 w-100 p-2">
    <div class="d-flex flex-column align-items-center gap-2">
      <h3>Create account.</h3>
      <router-link class="text-decoration-none" :to="{ name: 'login' }">
        <p class="text-muted">Already have an account? <b class="">Sing in here</b></p>
      </router-link>
    </div>
    <div class="mt-3">
      <label for="userName" class="form-label">User Name</label>
      <input
        v-model="user.userName"
        type="text"
        :class="[errors.userName.length > 0 ? 'is-invalid' : '', 'form-control']"
        id="userName"
        required
      />
      <div v-if="errors.userName.length > 0" id="userName" class="invalid-feedback">
        <p v-for="error in errors.userName" key="error" class="m-0">
          {{ error }}
        </p>
      </div>
    </div>
    <div class="">
      <label for="email" class="form-label">Email address</label>
      <input
        v-model="user.email"
        type="email"
        :class="[errors.email.length > 0 ? 'is-invalid' : '', 'form-control']"
        id="email"
        aria-describedby="emailHelp"
        required
      />
      <div v-if="errors.email.length > 0" id="email" class="invalid-feedback">
        <p v-for="error in errors.email" key="error" class="m-0">
          {{ error }}
        </p>
      </div>
      <div v-if="errors.email.length == 0" id="emailHelp" class="form-text">
        We'll never share your email with anyone else.
      </div>
    </div>
    <div class="d-flex gap-2">
      <div class="w-50">
        <label for="firstName" class="form-label">First name</label>
        <input
          v-model="user.firstName"
          type="text"
          :class="[errors.firstName.length > 0 ? 'is-invalid' : '', 'form-control']"
          id="firstName"
          required
        />
        <div v-if="errors.firstName.length > 0" id="firstName" class="invalid-feedback">
          <p v-for="error in errors.firstName" key="error" class="m-0">
            {{ error }}
          </p>
        </div>
      </div>
      <div class="w-50">
        <label for="lastName" class="form-label">Last name</label>
        <input
          v-model="user.lastName"
          type="text"
          :class="[errors.lastName.length > 0 ? 'is-invalid' : '', 'form-control']"
          id="lastName"
          required
        />
        <div v-if="errors.lastName.length > 0" id="lastName" class="invalid-feedback">
          <p v-for="error in errors.lastName" key="error" class="m-0">
            {{ error }}
          </p>
        </div>
      </div>
    </div>
    <div class="">
      <label for="password" class="form-label">Password</label>
      <input
        v-model="user.password"
        type="password"
        :class="[errors.password.length > 0 ? 'is-invalid' : '', 'form-control']"
        id="password"
        required
      />
      <div v-if="errors.password.length > 0" id="lastName" class="invalid-feedback">
        <p v-for="error in errors.password" key="error" class="m-0">
          {{ error }}
        </p>
      </div>
    </div>
    <div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</template>

<script>
import axios from "axios";

export default {
  name: "register",
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
    register(e) {
      e.preventDefault();

      const user = {
        login: this.user.userName,
        first_name: this.user.firstName,
        last_name: this.user.firstName,
        email: this.user.email,
        password: this.user.password,
      };

      axios
        .post("register", user)
        .then((response) => {
          if (response.request.status == 201) {
            this.$store.commit("updateUser", {
              ...this.$store.state.user,
              userName: this.user.userName,
              firstName: this.user.firstName,
              lastName: this.user.lastName,
              email: this.user.email,
              password: this.user.password,
              token: response.data.token,
            });

            axios.defaults.headers.common["Authorization"] = response.data.token;

            this.$router.push({name: 'home'})
          }
        })
        .catch((e) => {
          this.setErrors(e.response.data.errors);
        });
    },

    setErrors(errors) {
      this.errors = {
        userName: [],
        email: [],
        firstName: [],
        lastName: [],
        password: [],
      };

      for (const field in errors) {
        switch (field) {
          case "login":
            this.errors.userName = this.errors.userName.concat(errors[field]);
            break;
          case "email":
            this.errors.email = this.errors.email.concat(errors[field]);
            break;
          case "first_name":
            this.errors.firstName = this.errors.firstName.concat(errors[field]);
            break;
          case "last_name":
            this.errors.lastName = this.errors.lastName.concat(errors[field]);
          case "password":
            this.errors.password = this.errors.password.concat(errors[field]);
            break;
        }
      }
    },
  },
};
</script>
