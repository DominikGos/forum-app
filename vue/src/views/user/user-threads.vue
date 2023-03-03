<template>
  <div class="p-3 bg-white shadow-sm rounded-3 d-flex flex-column gap-4">
    <div class="d-flex justify-content-between">
      <h4>User started threads.</h4>
      <select class="form-select w-auto" aria-label="Default select example">
        <option selected>Sort by</option>
        <option value="1">Oldest</option>
        <option value="2">Newest</option>
      </select>
    </div>
    <threads v-if="threads.length > 0" :threads="threads" />
    <p v-else class="text-muted">
      User has no threads.
    </p>
    <nav aria-label="..." v-if="threads.length > 0">
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
import threads from "../../components/thread/threads.vue";
import userMixin from "../../mixins/user.vue";
import axios from "axios";

export default {
  name: "userThreads",
  mixins: [userMixin],
  props: {
    propUser: Object,
  },
  components: { threads },
  data() {
    return {
      threads: [],
    };
  },
  async mounted() {
    this.user = this.propUser;

    if (this.user.id == null) {
      await this.setUser(this.$route.params.id);
    }

    await this.setThreads(this.user.id);
  },
  methods: {
    async setThreads(id) {
      this.threads = await this.fetchThreads(id);
    },
    async fetchThreads(id) {
      const response = await axios.get(`users/${id}/threads`);

      return response.data.threads;
    },
  },
};
</script>
