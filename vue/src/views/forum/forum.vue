<template>
  <div>
    <hero />
    <div class="mt-5 container p-3">
      <div class="row mb-4">
        <div class="col-12">
          <h3>{{ forum.name }}</h3>
          <p class="text-muted">{{ forum.description }}</p>
        </div>
      </div>
      <div class="row justify-content-between">
        <div class="col-lg-3 col-xl-2 d-none d-lg-flex">
          <tags :tags="tags" />
        </div>
        <div class="col-lg-8 col-xl-7 d-flex flex-column gap-5">
          <banner>
            <template v-slot:icon>
              <img src="../../../public/images/conversation.png" alt="question" />
            </template>
            <template v-slot:content>
              <h3>You can not find an answer?</h3>
              <p class="text-muted m-0" @click="openCreateThreadForm(modalComponentName)">
                Ask question!
              </p>
            </template>
            <template v-slot:button>
              <button
                class="btn btn-primary"
                @click="openCreateThreadForm(modalComponentName)"
              >
                Create thread
              </button>
            </template>
          </banner>
          <thread-list :threads="threads" />
        </div>
        <div class="col-xl-3 d-none d-xl-flex align-items-start">
          <most-helpful />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import hero from "../../components/hero.vue";
import avatar from "../../components/avatar.vue";
import tags from "../../components/tags.vue";
import mostHelpful from "../../components/most-helpful.vue";
import threadList from "../../components/thread/threads.vue";
import Banner from "../../components/banner.vue";
import threadMixin from '../../mixins/thread.vue'
import tagMixin from '../../mixins/tag.vue'

export default {
  name: "forum",
  components: {
    hero,
    avatar,
    tags,
    mostHelpful,
    threadList,
    Banner,
  },
  mixins: [
    threadMixin,
    tagMixin
  ],
  data() {
    return {
      forum: {},
      threads: [],
    }
  },
  async mounted() {
    this.forum = await this.fetchForum(this.$route.params.id)
    this.threads = await this.fetchThreads()
    this.setTags()
  },
  methods: {
    async fetchForum(id) {
      try {
        const response = await axios.get(`forums/${id}`);

        return response.data.forum;
      } catch (error) {
        return null;
      }
    },
    async fetchThreads() {
      try {
        const response = await axios.get(`forums/${this.forum.id}/threads`);

        return response.data.threads;
      } catch (error) {
        return [];
      }
    },
  },
};
</script>
