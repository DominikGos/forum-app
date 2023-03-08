<template>
  <div
    :class="[
      reply.isAccepted ? 'bg-success bg-opacity-10 p-4' : '',
      'd-flex gap-2 mt-3 w-100',
    ]"
  >
    <div class="d-flex align-items-start gap-2 w-100">
      <router-link
        :to="{ name: 'user', params: { id: reply.user.id } }"
        class="text-decoration-none"
      >
        <avatar :photo="reply.user.avatarPath" style="transform: scale(0.75)" />
      </router-link>
      <div :class="[reply.isAccepted ? '' : 'border-bottom', ' pb-3 w-100']">
        <div class="d-flex justify-content-between">
          <router-link
            :to="{ name: 'user', params: { id: reply.user.id } }"
            class="text-decoration-none"
          >
            <h6 class="m-0 text-dark">
              {{ reply.user.firstName }} {{ reply.user.lastName }}
            </h6>
          </router-link>
          <p v-if="reply.isAccepted" class="m-0 text-success">
            <i class="fa-solid fa-check text-success me-1"></i>Accepted solution
          </p>
        </div>
        <p class="m-0 mt-2 text-muted">
          <i class="fa-regular fa-calendar"></i> {{ reply.timestamps.createdAt }}
        </p>
        <p class="text-muted mt-3">
          {{ reply.content }}
        </p>
        <div
          v-if="!reply.isAccepted"
          class="d-flex gap-2 justify-content-end align-items-center text-muted"
        >
          <div class="d-flex gap-2 justify-content-between">
            <div>
              <i class="fa-regular fa-heart"></i>
              {{ reply.likes }}
            </div>
          </div>
        </div>
        <a v-if="reply.isAccepted" href="#" class="text-decoration-none">
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
    reply: Object,
  },
  mounted() {},
};
</script>
