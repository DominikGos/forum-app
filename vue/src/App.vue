<template>
  <router-view v-slot="{ Component }">
    <transition name="route" mode="out-in">
      <component :is="Component" />
    </transition>
  </router-view>
</template>

<script setup>

</script>

<script>
import styles from "./sass/main.sass";
import authentication from './mixins/authentication.vue'

export default {
  name: "app",
  mixins: [
    authentication,
  ],
  created() {
    const user = JSON.parse(localStorage.getItem('user'))

    if(user) {
      this.$store.commit('updateUser', user)

      this.setTokenAsDefault(user.token)
    }
  },
};
</script>


