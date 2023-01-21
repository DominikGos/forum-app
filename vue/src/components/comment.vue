<template>
  <div
    :class="[
      this.isAccepted ? 'bg-success bg-opacity-10 p-4' : '',
      'd-flex gap-2 mt-3',
    ]"
  >
    <div class="d-flex align-items-start gap-2">
      <avatar style="transform: scale(0.75)" />
      <div :class="[this.isAccepted ? '' : 'border-bottom', ' pb-3']">
        <div class="d-flex justify-content-between">
          <h6 class="m-0">User Name</h6>
          <p v-if="this.isAccepted" class="m-0 text-success">
            <i class="fa-solid fa-check text-success me-1"></i>Accepted solution
          </p>
        </div>
        <p class="m-0 mt-2 text-muted">
          <i class="fa-regular fa-calendar"></i> February 20 at 9:32 PM
        </p>
        <p class="text-muted mt-3">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in
          tristique quam. Sed at elit turpis. Praesent dignissim erat eu aliquet
          tristique.
        </p>
        <div
          v-if="!this.isAccepted"
          class="
            d-flex
            gap-2
            justify-content-between
            align-items-center
            text-muted
          "
        >
          <button class="btn btn-primary">Reply</button>
          <div class="d-flex gap-2 justify-content-between">
            <div>
              <i class="fa-regular fa-heart"></i>
              23
            </div>
            <div>
              <i class="fa-regular fa-comment"></i>
              54
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import avatar from "./avatar.vue";
export default {
  components: { avatar },
  name: "comment",
  props: {
    isAccepted: Boolean,
  },
};
</script>
