<template>
  <div class="d-flex flex-column border rounded-3">
    <div
      class="d-flex border-bottom gap-2 align-items-center justify-content-between p-3 bg-body-secondary"
    >
      <slot name="header"></slot>
    </div>
    <div class="d-flex flex-column">
      <div
        v-for="(item, index) in items"
        :class="[
          index == items.length - 1 ? '' : 'border-bottom',
          smallPaddingInItem ? 'ps-2 pe-2' : 'p-3',
          'd-flex gap-2 align-items-center justify-content-between bg-white',
        ]"
      >
        <slot name="item" v-bind="item"></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "appTable",
  props: {
    items: Array,
    smallPaddingInItem: Boolean
  },
  mounted() {
   // console.log(this.items)
  },
};
</script>
