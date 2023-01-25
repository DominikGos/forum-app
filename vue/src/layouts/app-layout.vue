<template>
  <modal />
  <div class="bg-light">
    <app-navbar />
    <router-view></router-view>
    <app-footer />
  </div>
</template>

<script>
import appFooter from '../components/footer.vue'
import modal from '../components/modal.vue'
import appNavbar from '../components/navbar.vue'
export default {
  components: { appNavbar, appFooter, modal },
  name: 'appLayout'
}
</script>
