<template>
  <div
    :class="[this.photo ? 'bg-body-secondary' : '', 'avatar rounded-circle overflow-hidden d-flex justify-content-center align-items-center']"
  >
    <img v-if="this.photo" :src="this.photo"/>
    <img v-else :src="this.defaultPhoto"/>
  </div>
</template>

<script>
export default {
  name: "avatar",
  props: {
    photo: String,
  },
  data() {
    return {
      defaultPhoto: '/public/images/user.png'
    }
  },
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
