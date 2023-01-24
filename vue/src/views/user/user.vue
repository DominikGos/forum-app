<template>
  <div class="hero"></div>
  <div class="container p-4" style="margin-top: 150px !important">
    <div class="row gap-5 flex-lg-nowrap justify-content-center align-items-start">
      <div class="p-3 w-auto bg-white shadow-sm rounded-3 d-flex flex-column gap-3" style="z-index: 1000">
        <div
          class="
            profile-avatar
            bg-white
            overflow-hidden
            d-flex
            justify-content-center
            align-items-center
            p-0
            rounded-3
          "
        >
          <img src="/images/pexels-pixabay-220453.jpg" alt="avatar"/>
        </div>
        <div>
          <h4 class="m-0">User Name</h4>
          <p class="text-muted m-0">Short text</p>
        </div>
        <router-link :to="{name: 'user' }" :class="[ $route.name == 'user' ? 'btn-primary' : 'btn-secondary', 'btn']">
          Profile
        </router-link>
        <router-link :to="{name: 'threads' }" :class="[ $route.name == 'threads' ? 'btn-primary' : 'btn-secondary', 'btn']">
          Topics
        </router-link>
        <router-link :to="{name: 'replies' }" :class="[ $route.name == 'replies' ? 'btn-primary' : 'btn-secondary', 'btn']">
          Replies
        </router-link>
      </div>

      <div class="col-lg-8 p-3 bg-white shadow-sm rounded-3 d-flex flex-column gap-4" style="z-index: 1000">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "user",
};
</script>

<style lang="sass">
.profile-avatar
  min-width: 200px
  max-width: 200px
  width: 200px !important
  height: 200px
  position: relative
  z-index: 1000

  img
    min-width: 100%
    min-height: 100%
</style>

