<template>
  <div class="p-3 bg-white shadow-sm rounded-3 d-flex flex-column gap-4">
    <slot name="body"></slot>
  </div>
</template>

<script>
export default {
  name: 'profileContent'
}
</script>
