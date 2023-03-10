<template>
  <div>

    <hero />
    <div class="mt-5 container">
      <div class="row justify-content-center gap-3">
        <div class="col-lg-8 d-flex flex-column gap-4">
          <div class="d-flex align-items-center">
            <div v-if="thread && thread.user" style="width: 70px">
              <router-link :to="{ name: 'user', params: {id: thread.user.id} }">
                <avatar style="transform: scale(0.75)" :photo="thread.user.avatarPath" />
              </router-link>
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
          <reply v-if="acceptedReply && acceptedReply.user" :reply="acceptedReply" />
          <h4 class="mt-5">Replies</h4>
          <reply-form />
          <div v-for="reply in replies">
            <reply :reply="reply" />
          </div>
        </div>
        <div class="col-lg-3 d-none d-lg-flex flex-column gap-5">
          <forums />
          <tags :tags="thread.tags" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import avatar from "../../components/user/avatar.vue";
import forums from "../../components/forum/forums.vue";
import replyForm from '../../components/reply/reply-form.vue';
import reply from "../../components/reply/reply.vue";
import hero from "../../components/hero.vue";
import tags from "../../components/tags.vue";
import axios from 'axios';

export default {
  components: { hero, avatar, tags, reply, forums, replyForm },
  name: "thread",
  data() {
    return {
      thread: {},
      replies: [],
      acceptedReply: {},
    }
  },
  async mounted() {
    this.thread = await this.fetchThread(this.$route.params.id, this.$route.params.threadId)
    this.replies = await this.fetchReplies(this.$route.params.threadId)
    this.acceptedReply = this.getAcceptedReply(this.replies)
  },
  methods: {
    async fetchThread(forumId, threadId) {
      try {
        const response = await axios.get(`forums/${forumId}/threads/${threadId}`)

        return response.data.thread
      } catch (error) {
        return null
      }
    },
    async fetchReplies(threadId) {
      try {
        const response = await axios.get(`/threads/${threadId}/replies`)

        return response.data.replies
      } catch (error) {
        return null
      }
    },
    getAcceptedReply(replies) {
      let acceptedReplies = replies.filter(reply => {
        return reply.isAccepted
      })

      return acceptedReplies[0]
    }
  },
};
</script>
