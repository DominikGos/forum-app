<template>
  <div class="d-flex flex-column gap-2">
    <h3>Forums</h3>

    <div
      v-for="forum in forums"
      class="d-flex border-bottom gap-2 align-items-center justify-content-between p-2"
    >
      <img :src="forum.image" width="25" alt="forum" />
      <p class="m-0">{{ forum.name }}</p>
      <div class="rounded-circle ps-2 pe-2 p-1 bg-body-secondary">24</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "forums",
  props: {
    forums: Array,
  },
};
</script>
