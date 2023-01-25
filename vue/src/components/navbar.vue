<template>
  <nav class="app-navbar navbar navbar-expand-lg p-2">
    <div class="container container-fluid p-3">
      <router-link class="navbar-brand" :to="{ name: 'home' }">
        <i class="fa-brands fa-laravel fs-1"></i>
      </router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbar"
        aria-controls="navbar"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar">
        <ul
          class="
            navbar-nav
            me-auto
            mb-2 mb-lg-0
            w-100
            justify-content-end
            align-items-center
            gap-2
          "
        >
          <li class="nav-item">
            <router-link class="nav-link active" :to="{ name: 'home' }"> Home </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" :to="{ name: 'forum'}"> Forum </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" :to="{ name: 'threads'}"> Threads </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" :to="{ name: 'thread', params: {id: 1} }"> Thread </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" :to="{ name: 'user', params: {id: 1} }"> User </router-link>
          </li>
          <li class="nav-item">
            <router-link class="btn btn-primary" :to="{name: 'login'}">Login</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "navbar",
};
</script>

<style scoped lang="sass">
.app-navbar
  z-index: 100

@media screen and (max-width: 992px)
  #navbar
    background-color: white !important
    margin-top: .5rem
    border-radius: .5rem
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important
    padding: .5rem

    ul
      align-items: start !important
</style>
