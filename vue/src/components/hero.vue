<template>
  <header
    class="
      hero
      d-flex
      flex-column
      justify-content-center
      align-items-center
      gap-3
      p-3
    "
  >
    <form class="d-flex p-3 bg-white gap-2 rounded-3 mt-3" role="search">
      <input
        class="form-control"
        type="search"
        placeholder="Search"
        aria-label="Search"
      />
      <button class="btn btn-primary" type="submit">Search</button>
    </form>
  </header>
</template>

<script>
export default {
  name: "hero",
};
</script>

<style lang="sass">
.hero
  background-image: url('../public/images/rm222-mind-16.jpg')
  background-repeat: no-repeat
  background-attachment: scroll
  background-position: center
  background-size: cover
  position: absolute
  top: 0
  left: 0
  right: 0
  height: 400px
</style>
