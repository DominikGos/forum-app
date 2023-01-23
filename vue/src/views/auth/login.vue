<template>
  <form class="d-flex flex-column gap-3 w-100 p-2">
    <div class="d-flex flex-column align-items-center gap-2">
      <h3>Create account.</h3>
      <router-link class="text-decoration-none" :to="{name: 'register'}">
        <p class="text-muted">Do you have no account yet? <b class="">Sing up here</b> </p>
      </router-link>
    </div>
    <div class="mt-3">
      <label for="exampleInputText1" class="form-label">Username</label>
      <input type="text" class="form-control" id="exampleInputText1" />
    </div>
    <div class="">
      <label for="exampleInputPassword1" class="form-label">Password</label>
      <input type="password" class="form-control" id="exampleInputPassword1" />
    </div>
    <div class="form-check">
      <input type="checkbox" class="form-check-input" id="exampleCheck1" />
      <label class="form-check-label" for="exampleCheck1">Check me out</label>
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
