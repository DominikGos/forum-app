<template>
  <router-view v-slot="{ Component }">
    <transition name="route" mode="out-in">
      <component :is="Component" />
    </transition>
  </router-view>
</template>

<script >
import styles from "./sass/main.sass";

export default {
  name: "app",
};
</script>


