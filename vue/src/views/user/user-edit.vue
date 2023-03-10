<template>
  <profile-content>
    <template v-slot:body>
      <form>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input
            v-model="user.email"
            type="email"
            class="form-control"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
          />
        </div>
        <div class="d-flex gap-2 mb-3">
          <div class="w-50">
            <label for="firstName" class="form-label">First name</label>
            <input
              v-model="user.firstName"
              type="text"
              class="form-control"
              id="firstName"
              required
            />
          </div>
          <div class="w-50">
            <label for="lastName" class="form-label">Last name</label>
            <input
              v-model="user.lastName"
              type="text"
              class="form-control"
              id="lastName"
              required
            />
          </div>
        </div>
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"
            >Example textarea</label
          >
          <textarea
            class="form-control"
            id="exampleFormControlTextarea1"
            rows="3"
            v-model="user.description"
          ></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </template>
  </profile-content>
</template>

<script>
/*  <!-- email,
        firstName,
        lastName,
        description,
        avatar,
        deleteAvatar,, --> */
import profileContent from "../../components/user/profile-content.vue";
import userMixin from "../../mixins/user.vue";

export default {
  name: "userEdit",
  mixins: [userMixin],
  props: {
    propUser: Object,
  },
  components: {
    profileContent,
  },
  async mounted() {
    this.user = this.propUser;
    console.log(this.user);
    if (this.user.id == null) {
      await this.setUser(this.$route.params.id);
    }
  },
};
</script>
