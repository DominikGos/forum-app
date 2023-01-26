<template>
  <div class="d-flex flex-column border rounded-3">
    <div
      class="
        d-flex
        border-bottom
        gap-2
        align-items-center
        justify-content-between
        p-3
        bg-body-secondary
      "
    >
      <div class="col-7">Forum</div>
      <div class="col-lg-2 d-none d-lg-block">Topics</div>
      <div class="col-lg-2 d-none d-lg-block">Last post</div>
    </div>
    <div class="d-flex flex-column">
      <div
        class="
          d-flex
          border-bottom
          gap-2
          align-items-center
          justify-content-between
          p-3
          bg-white
        "
      >
        <div class="col-2 d-flex justify-content-center">
          <img src="/public/images/musical-notes.png" width="25" />
        </div>
        <div class="col-9 col-lg-5">
          <h5>music</h5>
          <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
        </div>
        <div class="col-lg-2 d-none d-lg-block">
          <p class="m-0">121</p>
        </div>
        <div class="col-lg-2 d-none d-lg-block">
          <p class="m-0">1 year ago</p>
        </div>
      </div>
      <div
        class="
          d-flex
          gap-2
          align-items-center
          justify-content-between
          p-3
          bg-white
        "
      >
        <div class="col-2 d-flex justify-content-center">
          <img src="/public/images/game-console.png" width="25" />
        </div>
        <div class="col-9 col-lg-5">
          <h5>Games</h5>
          <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
        </div>
        <div class="col-lg-2 d-none d-lg-block">
          <p class="m-0">130</p>
        </div>
        <div class="col-lg-2 d-none d-lg-block">
          <p class="m-0">2 year ago</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "forumsTable",
};
</script>
