<template>
  <form v-if="errors" @submit="login($event)" class="d-flex flex-column gap-3 w-100 p-2">
    <div class="d-flex flex-column align-items-center gap-2">
      <h3>Log in to your account.</h3>
      <router-link class="text-decoration-none" :to="{ name: 'register' }">
        <p class="text-muted">Do you have no account yet? <b class="">Sing up here</b></p>
      </router-link>
    </div>
    <div class="mt-3">
      <label for="email" class="form-label">Email address</label>
      <input
        v-model="user.email"
        type="email"
        :class="[errors.email.length > 0 ? 'is-invalid' : '', 'form-control']"
        id="email"
        required
      />
      <div v-if="errors.email.length > 0" id="email" class="invalid-feedback">
        <p v-for="error in errors.email" key="error" class="m-0">
          {{ error }}
        </p>
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
      <div v-if="errors.password.length > 0" id="password" class="invalid-feedback">
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
import authentication from "../../mixins/authentication.vue";
import validationErrors from "../../mixins/validation-errors.vue";
import userMixin from '../../mixins/user.vue';

export default {
  name: "login",
  mixins: [authentication, validationErrors, userMixin],
  mounted() {
    this.errors = {
      email: [],
      password: [],
    };
  },
  methods: {
    login(e) {
      e.preventDefault();

      const mappedUser = {
        email: this.user.email,
        password: this.user.password,
      };

      axios
        .post("login", mappedUser)
        .then((response) => {
          if (response.request.status == 200) {
            this.saveUserInVuex(response.data.user, response.data.token);
            this.redirect();
            this.setTokenAsDefault(response.data.token);
            this.saveUserInStorage()
          }
        })
        .catch((e) => {
          this.setErrors(e.response.data.errors);
        });
    },
  },
};
</script>

