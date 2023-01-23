<template>
  <div class="container-fluid p-0 overflow-hidden">
    <div class="row gap-4 h-100">
      <div class="col-lg-4 col-xl-3">
        <div
          class="
            hero
            d-flex
            justify-content-center
            align-items-center align-items-lg-start
            p-3
          "
        >
          <h1 class="text-white text-center">Tell us what do you think.</h1>
        </div>
      </div>
      <div
        class="
          col-lg-7 col-xl-8
          d-flex
          justify-content-center
          flex-column
          align-items-center
          p-3
        "
      >
        <router-view class="auth-form"></router-view>
        <router-link class="text-decoration-none" :to="{ name: 'home' }"
          >Back to home <i class="fa-solid fa-arrow-left ms-2"></i
        ></router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "authLayout",
};
</script>

<style lang="sass" scoped>
.hero
  height: 200px !important
  position: static !important
  background-image: url('../images/5559852.jpg') !important

@media screen and (min-width: 992px)
  .hero
    height: 100vh !important
    background-position: start bottom !important
    background-image: url('../images/5559852-vertical.jpg') !important

  .auth-form
    width: 600px !important
</style>
