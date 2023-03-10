<template>
  <div
    class="profile-avatar bg-white overflow-hidden d-flex justify-content-center align-items-center p-0 rounded-3"
  >
    <img v-if="photo" :src="photo" alt="avatar" />
    <img v-else :src="defaultPhoto" alt="avatar" />
  </div>
</template>

<script>
import userMixin from '../../mixins/user.vue'

export default {
  name: "squareAvatar",
  props: {
    photo: String,
  },
  mixins: [
    userMixin
  ]
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
