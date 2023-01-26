<template>
  <div
    @click="closeModal($event)"
    data-is-close-button="true"
    :class="[
      $store.state.modal.open
        ? 'app-modal-visible bg-dark bg-opacity-75'
        : 'app-modal-invisible',
      `app-modal
      p-3
      position-fixed
      top-0
      left-0
      bottom-0
      w-100
      h-100
      overflow-y-auto`
    ]"
  >
    <div
      :class="[
        $store.state.modal.open
          ? 'app-modal-body-visible'
          : 'app-modal-body-invisible',
        'app-modal-body d-flex flex-column bg-white p-3 rounded-3 shadow m-auto',
      ]"
    >
      <div class="w-100 d-flex justify-content-end">
        <button class="btn-close" @click="closeModal($event)" data-is-close-button="true">
        </button>
      </div>
      <create-thread-form v-if="$store.state.modal.componentName == 'createThreadForm'" />
    </div>
  </div>
</template>

<script>
import createThreadForm from './thread/create-thread-form.vue';

export default {
  components: { createThreadForm },
  name: "modal",
  methods: {
    closeModal(e) {
      const isCloseButton = (e.target.dataset.isCloseButton && e.target.dataset.isCloseButton == 'true')

      if(isCloseButton) {
        this.$store.commit("closeModal");
      }
    },
    openModal() {
      this.$store.commit("openModal");
    },
  },
  watch: {
    "$store.state.modal.open"() {
      const body = document.body;
      const isTheModalOpen = this.$store.state.modal.open;

      if (isTheModalOpen) {
        body.classList.add("overflow-hidden");
      } else {
        body.classList.remove("overflow-hidden");
      }
    },
  },
};
</script>

<style lang="sass">
.app-modal
  z-index: 1100
  transition: all .5s

  &-invisible
    opacity: 0
    visibility: hidden

  &-visible
    opacity: 1
    visibility: visible

  .app-modal-body
    width: 100%
    transform: translate(-100px, 0)
    transition: all .5s

    &-visible
      transform: translate(0, 0)

    &-invisible
      transform: translate(-100px, 0)

@media screen and (min-width: 768px)
  .app-modal
    z-index: 1100

    .app-modal-body
      width: 500px !important
      margin-top: 50px !important
</style>
