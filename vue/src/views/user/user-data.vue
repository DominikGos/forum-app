<template>
  <div class="p-3 bg-white shadow-sm rounded-3 d-flex flex-column gap-4">
    <div class="d-flex flex-column flex-lg-row gap-3">
      <div
        class="d-flex flex-grow-1 flex-column align-items-center gap-3 p-4 rounded-3 border"
      >
        <img src="/images/user.png" alt="User role" width="60" />
        <h5>User Role</h5>
        <p class="btn btn-primary">Master</p>
      </div>
      <div
        class="d-flex flex-grow-1 flex-column align-items-center gap-3 p-4 rounded-3 border"
      >
        <img src="/images/blog.png" alt="Threads" width="60" />
        <h5>Threads</h5>
        <p class="btn btn-primary">34</p>
      </div>
      <div
        class="d-flex flex-grow-1 flex-column align-items-center gap-3 p-4 rounded-3 border"
      >
        <img src="/images/comment.png" alt="Replies" width="60" />
        <h5>Replies</h5>
        <p class="btn btn-primary">144</p>
      </div>
    </div>
    <div v-if="user" class="d-flex flex-column gap-3">
      <div class="d-flex flex-row">
        <div class="col-3">
          <p class="fw-bolder">User name:</p>
        </div>
        <div class="col-7">
          <p class="text-muted">{{ user.login }}</p>
        </div>
      </div>
      <div class="d-flex flex-row">
        <div class="col-3">
          <p class="fw-bolder">Name:</p>
        </div>
        <div class="col-7">
          <p class="text-muted">{{ user.firstName }} {{ user.lastName }}</p>
        </div>
      </div>
      <div class="d-flex flex-row">
        <div class="col-3">
          <p class="fw-bolder">Joined at:</p>
        </div>
        <div class="col-7" v-if="user.timestamps">
          <p class="text-muted">{{ user.timestamps.createdAt }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "userData",
  props: {
    user: Object,
  },
};
</script>
