<template>
  <profile-content>
    <template v-slot:body>
      <div v-if="propUser" class="d-flex flex-column flex-lg-row gap-3">
        <div
          class="d-flex flex-grow-1 flex-column align-items-center gap-3 p-4 rounded-3 border"
        >
          <img src="/images/user.png" alt="user role" width="60" />
          <h5>Role</h5>
          <p class="btn btn-primary" >
            <p v-for="role in propUser.roles" class="m-0">
              {{ role }}
            </p>
          </p>
        </div>
        <div
          class="d-flex flex-grow-1 flex-column align-items-center gap-3 p-4 rounded-3 border"
        >
          <img src="/images/blog.png" alt="Threads" width="60" />
          <h5>Threads</h5>
          <p class="btn btn-primary">{{ propUser.threadCount }}</p>
        </div>
        <div
          class="d-flex flex-grow-1 flex-column align-items-center gap-3 p-4 rounded-3 border"
        >
          <img src="/images/comment.png" alt="Replies" width="60" />
          <h5>Replies</h5>
          <p class="btn btn-primary"> {{ propUser.replyCount }}</p>
        </div>
      </div>
      <div v-if="propUser" class="d-flex flex-column gap-3">
        <div class="d-flex flex-row">
          <div class="col-3">
            <p class="fw-bolder">User name:</p>
          </div>
          <div class="col-7">
            <p class="text-muted">{{ propUser.login }}</p>
          </div>
        </div>
        <div class="d-flex flex-row">
          <div class="col-3">
            <p class="fw-bolder">Name:</p>
          </div>
          <div class="col-7">
            <p class="text-muted">{{ propUser.firstName }} {{ propUser.lastName }}</p>
          </div>
        </div>
        <div class="d-flex flex-row">
          <div class="col-3">
            <p class="fw-bolder">Joined at:</p>
          </div>
          <div class="col-7" v-if="propUser.timestamps">
            <p class="text-muted">{{ propUser.timestamps.createdAt }}</p>
          </div>
        </div>
      </div>
    </template>
  </profile-content>
</template>

<script>
import profileContent from "../../components/user/profile-content.vue";

export default {
  name: "propUserData",
  props: {
    propUser: Object,
  },
  components: {
    profileContent,
  }
};
</script>
