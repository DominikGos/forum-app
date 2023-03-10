<template>
  <div
    :class="[photo ? 'bg-body-secondary' : '', 'avatar rounded-circle overflow-hidden d-flex justify-content-center align-items-center']"
  >
    <img v-if="photo" :src="photo"/>
    <img v-else :src="defaultPhoto"/>
  </div>
</template>

<script>
import userMixin from '../../mixins/user.vue'

export default {
  name: "avatar",
  props: {
    photo: String,
  },
  mixins: [
    userMixin
  ]
};
</script>

<style lang="sass">
  .avatar
    min-width: 60px
    min-height: 60px
    max-width: 60px
    max-height: 60px

    img
      max-width: 100%
      max-height: 100%
</style>
