<template>
  <div class="bg-light">
    <modal />
    <app-navbar />
    <router-view v-slot="{ Component }">
      <transition name="route" mode="out-in">
        <component :is="Component" />
      </transition>
    </router-view>
    <app-footer />
  </div>
</template>

<script>
import appFooter from "../components/footer.vue";
import modal from "../components/modal.vue";
import appNavbar from "../components/navbar.vue";

export default {
  components: { appNavbar, appFooter, modal },
  name: "appLayout",
};
</script>
