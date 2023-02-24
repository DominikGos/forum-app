<template>
  <form class="d-flex flex-column gap-3 w-100 p-2">
    <div class="d-flex flex-column align-items-center gap-2">
      <h3>Create account.</h3>
      <router-link class="text-decoration-none" :to="{name: 'register'}">
        <p class="text-muted">Do you have no account yet? <b class="">Sing up here</b> </p>
      </router-link>
    </div>
    <div class="mt-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="email" />
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
export default {
  name: "login",
};
</script>
