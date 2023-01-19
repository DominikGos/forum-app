<template>
  <div class="bg-light">
    <app-navbar />
    <router-view></router-view>
    <app-footer />
  </div>
</template>

<script >

import appNavbar from './components/navbar.vue'
import appFooter from './components/footer.vue'

export default {
  name: "app",
  components: {
    appNavbar,
    appFooter,
  }
};
</script>


