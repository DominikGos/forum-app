<template>
  <div class="d-flex flex-column gap-2">
    <h3>Tags</h3>
    <div v-if="tags && tags.length > 0" class="d-flex gap-2 flex-wrap">
      <div v-for="tag in tags" class="rounded-3 bg-body-secondary ps-2 pe-2 p-1 d-flex align-items-center">
        {{ tag.name }}
      </div>
    </div>
    <p v-else-if=" ! tags && thread" class="text-secondary">
      The thread is not tagged.
    </p>
    <p v-else class="text-secondary">
      There are no tags.
    </p>
  </div>
</template>

<script>
export default {
  name: "tags",
  props: {
    tags: Array,
    thread: {
      default: null,
      type: Object,
    }
  }
};
</script>
