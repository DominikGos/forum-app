<template>
  <div class="d-flex flex-column border rounded-3">
    <div
      class="
        d-flex
        flex-wrap
        border-bottom
        gap-2
        align-items-center
        justify-content-between
        p-3
        background-gray-300
      "
      style="opacity: 0.75"
    >
      <h6 class="m-0">Most helpful</h6>
      <p class="text-muted m-0">Last 30 days.</p>
    </div>
    <div class="d-flex flex-column">
      <div
        class="
          d-flex
          justify-content-between
          align-items-center
          border-bottom
          w-100
          ps-2
          pe-2
        "
      >
        <div class="d-flex align-items-center">
          <avatar style="transform: scale(0.5)" />
          <p class="text-muted m-0">User Name</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import avatar from './avatar.vue'
export default {
  components: {
    avatar
  },
  name: "mostHelpful",
};
</script>
