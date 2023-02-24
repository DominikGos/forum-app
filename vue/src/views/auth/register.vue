<template>
  <form class="d-flex flex-column gap-3 w-100 p-2">
    <div class="d-flex flex-column align-items-center gap-2">
      <h3>Create account.</h3>
      <router-link class="text-decoration-none" :to="{name: 'login'}">
        <p class="text-muted">Already have an account? <b class="">Sing in here</b> </p>
      </router-link>
    </div>
    <div class="mt-3">
      <label for="userName" class="form-label">User Name</label>
      <input type="text" class="form-control" id="userName" />
    </div>
    <div class="">
      <label for="email" class="form-label">Email address</label>
      <input
        type="email"
        class="form-control"
        id="email"
        aria-describedby="emailHelp"
      />
      <div id="emailHelp" class="form-text">
        We'll never share your email with anyone else.
      </div>
    </div>
    <div class="d-flex gap-2">
      <div class="w-50">
        <label for="firstName" class="form-label">First name</label>
        <input type="text" class="form-control" id="firstName" />
      </div>
      <div class="w-50">
        <label for="lastName" class="form-label">Last name</label>
        <input type="text" class="form-control" id="lastName" />
      </div>
    </div>
    <div class="">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" />
    </div>
    <div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</template>

<script>
import axios from 'axios'

export default {
  name: "register",
};
</script>
