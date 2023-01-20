<template>
  <div
    class="
      container
      bg-white
      shadow
      gap-3
      d-flex
      flex-row
      justify-content-center
      align-items-center
      gap-4
      p-4
    "
  >
    <div class="d-flex justify-content-center">
      <img src="../../../public/images/conversation.png" alt="question" />
    </div>
    <div class="col">
      <h3>{{this.header}}</h3>
      <p class="text-muted m-0">{{ this.paragraph }}</p>
    </div>
    <div class="d-none d-lg-flex">
      <button class="btn btn-primary">{{ this.buttonText }}</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "banner",
  props: {
    imagePath: String,
    header: String,
    paragraph: String,
    buttonText: String,
  },
};
</script>
