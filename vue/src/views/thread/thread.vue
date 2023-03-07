<template>
  <div>

    <hero />
    <div class="mt-5 container">
      <div class="row justify-content-center gap-3">
        <div class="col-lg-8 d-flex flex-column gap-4">
          <div class="d-flex align-items-center">
            <div style="width: 70px">
              <avatar style="transform: scale(0.75)" />
            </div>
            <div v-if="thread.user">
              <h6 class="m-0">{{ thread.user.firstName }} {{ thread.user.lastName }}</h6>
              <p class="m-0 text-muted">
                <i class="fa-regular fa-calendar"></i> {{ thread.timestamps.createdAt }}
              </p>
            </div>
          </div>
          <div class="d-flex align-items-start align-items-lg-end">
            <h1 class="m-0 ps-2" style="width: 70px">Q:</h1>
            <h4 class="m-0">{{ thread.title }}</h4>
          </div>
          <div
            class="d-flex flex-column align-items-start gap-3"
            style="padding-left: 70px !important"
          >
            <p class="text-muted">
              {{ thread.description }}
            </p>
            <hr class="w-100" />
            <button class="btn btn-primary">Reply</button>
          </div>
          <!-- <comment :isAccepted="true" /> -->
          <h4 class="mt-5">Replies</h4>
          <!-- <comment-form />
          <comment :isAccepted="false" /> -->
        </div>
        <div class="col-lg-3 d-none d-lg-flex flex-column gap-5">
          <forums />
          <tags />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import avatar from "../../components/avatar.vue";
import forums from "../../components/forum/forums.vue";
import CommentForm from '../../components/comment/comment-form.vue';
import comment from "../../components/comment/comment.vue";
import hero from "../../components/hero.vue";
import tags from "../../components/tags.vue";
import axios from 'axios';

export default {
  components: { hero, avatar, tags, comment, forums, CommentForm },
  name: "thread",
  data() {
    return {
      thread: {}
    }
  },
  async mounted() {
    this.thread = await this.fetchThread(this.$route.params.id, this.$route.params.threadId)
  },
  methods: {
    async fetchThread(forumId, threadId) {
      try {
        const response = await axios.get(`forums/${forumId}/threads/${threadId}`)

        return response.data.thread
      } catch (error) {
        console.log('xdd', error)
        return null
      }
    }
  },
};
</script>
