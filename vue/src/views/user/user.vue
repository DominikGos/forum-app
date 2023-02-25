<template>
  <div>

    <div class="hero"></div>
    <div class="profile-content container p-4">
      <div
        class="row gap-5 flex-lg-nowrap justify-content-center align-items-start"
      >
        <div
          class="
            profile-section
            p-3
            w-auto
            bg-white
            shadow-sm
            rounded-3
            d-flex
            flex-column
            gap-3
          "
        >
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
            <img src="/images/pexels-pixabay-220453.jpg" alt="avatar" />
          </div>
          <div>
            <h4 class="m-0">User Name</h4>
            <p class="text-muted m-0">Short text</p>
          </div>
          <router-link
            :to="{ name: 'user' }"
            :class="[
              $route.name == 'user' ? 'btn-primary' : 'bg-body-secondary',
              'btn',
            ]"
          >
            Profile
          </router-link>
          <router-link
            :to="{ name: 'userThreads' }"
            :class="[
              $route.name == 'userThreads' ? 'btn-primary' : 'bg-body-secondary',
              'btn',
            ]"
          >
            Topics
          </router-link>
          <router-link
            :to="{ name: 'userReplies' }"
            :class="[
              $route.name == 'userReplies' ? 'btn-primary' : 'bg-body-secondary',
              'btn',
            ]"
          >
            Replies
          </router-link>
        </div>

        <div class="profile-section col-lg-8">
          <router-view v-slot="{ Component }">
            <transition name="route" mode="out-in">
              <component :is="Component" />
            </transition>
          </router-view>
        </div>
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
.profile-content
  transform: translate(0, -150px)

  .profile-section
    z-index: 1000

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

