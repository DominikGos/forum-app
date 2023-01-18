<template>
  <app-navbar />


  <router-view></router-view>
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


