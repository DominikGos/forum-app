<template>
  <div
    :class="[
      item.isAccepted ? 'bg-success bg-opacity-10 p-4' : '',
      'd-flex gap-2 mt-3 w-100',
    ]"
  >
    <div class="d-flex align-items-start gap-2 w-100">
      <avatar :photo="item.user.avatarPath" style="transform: scale(0.75)" />
      <div :class="[item.isAccepted ? '' : 'border-bottom', ' pb-3 w-100']">
        <div class="d-flex justify-content-between">
          <h6 class="m-0">User Name</h6>
          <p v-if="item.isAccepted" class="m-0 text-success">
            <i class="fa-solid fa-check text-success me-1"></i>Accepted solution
          </p>
        </div>
        <p class="m-0 mt-2 text-muted">
          <i class="fa-regular fa-calendar"></i> {{ item.timestamps.createdAt }}
        </p>
        <p class="text-muted mt-3">
          {{ item.content }}
        </p>
        <div
          v-if="!item.isAccepted"
          class="d-flex gap-2 justify-content-end align-items-center text-muted"
        >
          <div class="d-flex gap-2 justify-content-between">
            <div>
              <i class="fa-regular fa-heart"></i>
              {{ item.likes }}
            </div>
          </div>
        </div>
        <a v-if="item.isAccepted" href="#" class="text-decoration-none">
          <p class="m-0 text-primary">
            View full answer<i class="fa-solid fa-arrow-down ms-2"></i>
          </p>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import avatar from "../avatar.vue";
export default {
  components: { avatar },
  name: "comment",
  props: {
    item: Object,
  },
  mounted() {},
};
</script>
