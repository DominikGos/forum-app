<template>
  <div class="hero"></div>
  <div class="container p-4" style="margin-top: 150px !important">
    <div class="row gap-5 flex-lg-nowrap justify-content-center">
      <div class="p-3 w-auto bg-white shadow-sm rounded-3 d-flex flex-column gap-3" style="z-index: 1000">
        <div
          class="
            profile-avatar
            bg-white
            overflow-hidden
            d-flex
            justify-content-center
            align-items-center
            p-0
            rounded-3
          "
        >
          <img src="/images/pexels-pixabay-220453.jpg" alt="avatar"/>
        </div>
        <div>
          <h4 class="m-0">User Name</h4>
          <p class="text-muted m-0">Short text</p>
        </div>
        <router-link to="#" class="btn btn-primary">Profile</router-link>
        <router-link to="#" class="btn btn-secondary">Topics</router-link>
        <router-link to="#" class="btn btn-secondary">Replies</router-link>
      </div>

      <div class="col-lg-8 p-3 bg-white shadow-sm rounded-3 d-flex flex-column gap-4" style="z-index: 1000">
        <div class="d-flex flex-column flex-lg-row gap-3 ">
          <div class="d-flex flex-grow-1 flex-column align-items-center gap-3 p-4 rounded-3 border">
            <img src="/images/user.png" alt="User role" width="60">
            <h5>User Role</h5>
            <p class="btn btn-primary">Master</p>
          </div>
          <div class="d-flex flex-grow-1 flex-column align-items-center gap-3 p-4 rounded-3 border">
            <img src="/images/blog.png" alt="Threads" width="60">
            <h5>Threads</h5>
            <p class="btn btn-primary">34</p>
          </div>
          <div class="d-flex flex-grow-1 flex-column align-items-center gap-3 p-4 rounded-3 border">
            <img src="/images/comment.png" alt="Replies" width="60">
            <h5>Replies</h5>
            <p class="btn btn-primary">144</p>
          </div>
        </div>
        <div class="d-flex flex-column gap-3">
          <div class="d-flex flex-row">
            <div class="col-3">
              <p class="fw-bolder">Name:</p>
            </div>
            <div class="col-7">
              <p class="text-muted">User Name</p>
            </div>
          </div>
          <div class="d-flex flex-row">
            <div class="col-3">
              <p class="fw-bolder">Age:</p>
            </div>
            <div class="col-7">
              <p class="text-muted">23</p>
            </div>
          </div>
          <div class="d-flex flex-row">
            <div class="col-3">
              <p class="fw-bolder">Location:</p>
            </div>
            <div class="col-7">
              <p class="text-muted">Warsaw</p>
            </div>
          </div>
          <div class="d-flex flex-row">
            <div class="col-3">
              <p class="fw-bolder">Joined at:</p>
            </div>
            <div class="col-7">
              <p class="text-muted">2 January 2023</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "user",
};
</script>

<style lang="sass">
.profile-avatar
  min-width: 200px
  max-width: 200px
  width: 200px !important
  height: 200px
  position: relative
  z-index: 1000

  img
    min-width: 100%
    min-height: 100%
</style>

