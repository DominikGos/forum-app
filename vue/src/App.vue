<template>
  <div class="bg-light">
    <app-navbar />

    <router-view></router-view>
  </div>
</template>

<script >

import appNavbar from './components/navbar.vue'

export default {
  name: "app",
  components: {
    appNavbar
  }
};
</script>


