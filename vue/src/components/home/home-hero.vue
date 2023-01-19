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
    <h1 class="text-start">Hello, what are you looking for?</h1>
    <p class="text-muted fs-5">Find what you want.</p>
    <form class="d-flex p-3 bg-white gap-2 rounded-3 mt-3" role="search">
      <input
        class="form-control"
        type="search"
        placeholder="Search"
        aria-label="Search"
      />
      <select class="form-select" aria-label="Default select example">
        <option selected>Open this select menu</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
      <button class="btn btn-primary" type="submit">Search</button>
    </form>
    <div class="d-flex flex-row gap-2 align-items-center">
      <p class="m-0 text-muted me-2">Popular:</p>
      <div class="border border-secondary rounded-3 p-1 ps-2 pe-2">history</div>
      <div class="border border-secondary rounded-3 p-1 ps-2 pe-2">sport</div>
      <div class="border border-secondary rounded-3 p-1 ps-2 pe-2">it</div>
    </div>
  </header>
</template>

<script>
export default {
  name: "homeHero",
  components: {},
};
</script>

<style lang="sass" scoped>
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
  height: 700px
  margin-bottom: 700px
</style>
