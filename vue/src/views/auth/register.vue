<template>
  <form @submit="register($event)" class="d-flex flex-column gap-3 w-100 p-2">
    <div class="d-flex flex-column align-items-center gap-2">
      <h3>Create account.</h3>
      <router-link class="text-decoration-none" :to="{ name: 'login' }">
        <p class="text-muted">
          Already have an account? <b class="">Sing in here</b>
        </p>
      </router-link>
    </div>
    <div class="mt-3">
      <label for="userName" class="form-label">User Name</label>
      <input
        v-model="userName"
        type="text"
        class="form-control"
        id="userName"
        required
      />
    </div>
    <div class="">
      <label for="email" class="form-label">Email address</label>
      <input
        v-model="email"
        type="email"
        class="form-control"
        id="email"
        aria-describedby="emailHelp"
        required
      />
      <div id="emailHelp" class="form-text">
        We'll never share your email with anyone else.
      </div>
    </div>
    <div class="d-flex gap-2">
      <div class="w-50">
        <label for="firstName" class="form-label">First name</label>
        <input
          v-model="firstName"
          type="text"
          class="form-control"
          id="firstName"
          required
        />
      </div>
      <div class="w-50">
        <label for="lastName" class="form-label">Last name</label>
        <input
          v-model="lastName"
          type="text"
          class="form-control"
          id="lastName"
          required
        />
      </div>
    </div>
    <div class="">
      <label for="password" class="form-label">Password</label>
      <input
        v-model="password"
        type="password"
        class="form-control"
        id="password"
        required
      />
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
      userName: null,
      firstName: null,
      lastName: null,
      email: null,
      password: null,
    };
  },
  mounted() {
  },
  methods: {
    register(e) {
      e.preventDefault();

      const user = {
        login: this.userName,
        first_name: this.firstName,
        last_name: this.firstName,
        email: this.email,
        password: this.password,
      };

      axios
        .post("register", user)
        .then((response) => {
          if(response.request.status == 201) {
            this.$store.commit('updateUser', {
              ...this.$store.state.user,
              userName: this.userName,
              firstName: this.firstName,
              lastName: this.lastName,
              email: this.email,
              password: this.password,
              token: response.data.token
            })
          }
        });
    },
  },
};
</script>
