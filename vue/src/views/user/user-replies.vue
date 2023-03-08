<template>
  <div class="p-3 bg-white shadow-sm rounded-3 d-flex flex-column gap-4">
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
        <reply :reply="item"/>
      </template>
    </app-table>
    <p v-else class="text-muted">
      User has no replies.
    </p>
    <nav aria-label="..." v-if="replies.length > 0">
      <ul class="pagination">
        <li class="page-item disabled">
          <span class="page-link">Previous</span>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item active" aria-current="page">
          <span class="page-link">2</span>
        </li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
  </div>
</template>

<script>
import reply from "../../components/reply/reply.vue";
import userMixin from "../../mixins/user.vue";
import axios from "axios";
import appTable from '../../components/table/app-table.vue';

export default {
  name: "userReplies",
  mixins: [userMixin],
  props: {
    propUser: Object,
  },
  components: {
    reply,
    appTable
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
