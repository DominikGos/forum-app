<template>
  <div
    class="container bg-white shadow-sm gap-3 d-flex flex-row justify-content-center align-items-center gap-4 p-4"
  >
    <div class="d-flex justify-content-center">
      <slot name="icon"></slot>
    </div>
    <div class="col">
      <slot name="content"></slot>
    </div>
    <div class="d-none d-lg-flex">
      <slot name="button"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "banner",
  props: {
  },
};
</script>
