<template>
  <hero />
  <div class="content p-3">
    <banner
      :imagePath="'../../../public/images/conversation.png'"
      :header="'You can not find an answer?'"
      :paragraph="'Ask question!'"
      :buttonText="'Create thread'"
    />
  </div>
</template>

<script>
import hero from '../../components/hero.vue'
import banner from '../../components/banner.vue'

export default {
  name: 'threadList',
  components: {
    hero,
    banner
  }
}
</script>

<style lang="sass">
.content
  margin-top: 400px !important
</style>
