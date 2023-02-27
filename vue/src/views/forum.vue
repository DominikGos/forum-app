<template>
  <div>
    <hero />
    <div class="container p-3 mt-5">
      <div class="row gap-5">
        <div class="col-xl-8 d-flex flex-column gap-5">
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
              <button class="btn btn-primary" @click="openCreateThreadForm(modalComponentName)">
                Create thread
              </button>
            </template>
          </banner>
          <forums-table />
        </div>
        <div class="d-none col-xl-3 d-xl-flex flex-column gap-5">
          <forums />
          <tags />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import hero from "../components/hero.vue";
import banner from "../components/banner.vue";
import tags from "../components/tags.vue";
import forums from "../components/forum/forums.vue";
import modal from "../components/modal.vue";
import forumsTable from "../components/forum/forums-table.vue";

export default {
  name: "forum",
  components: {
    hero,
    banner,
    tags,
    forums,
    modal,
    forumsTable,
  },
  methods: {
    openCreateThreadForm() {
      this.$store.commit("openModal");
      this.$store.commit("updateComponentName", { name: 'createThreadForm' });
    },
  },
};
</script>
