<template>
  <profile-content>
    <template v-slot:body>
      <div class="d-flex justify-content-between">
        <h4>User replies.</h4>
        <select class="form-select w-auto" aria-label="Default select example">
          <option selected>Sort by</option>
          <option value="1">Oldest</option>
          <option value="2">Newest</option>
        </select>
      </div>
      <app-table v-if="replies.length > 0" :items="replies">
        <template v-slot:header>
          <p class="m-0">Number of replies: {{ replies.length }}</p>
        </template>
        <template #item="item">
          <reply :reply="item" />
        </template>
      </app-table>
      <p v-else class="text-muted">User has no replies.</p>
    </template>
  </profile-content>
</template>

<script>
import reply from "../../components/reply/reply.vue";
import userMixin from "../../mixins/user.vue";
import axios from "axios";
import appTable from "../../components/table/app-table.vue";
import profileContent from "../../components/user/profile-content.vue";

export default {
  name: "userReplies",
  mixins: [userMixin],
  props: {
    propUser: Object,
  },
  components: {
    reply,
    appTable,
    profileContent,
  },
  data() {
    return {
      replies: [],
    };
  },
  async mounted() {
    this.user = this.propUser;

    if (this.user.id == null) {
      await this.setUser(this.$route.params.id);
    }

    await this.setReplies(this.user.id);
  },
  methods: {
    async setReplies(id) {
      this.replies = await this.fetchReplies(id);
    },
    async fetchReplies(id) {
      const response = await axios.get(`users/${id}/replies`);

      return response.data.replies;
    },
  },
};
</script>
