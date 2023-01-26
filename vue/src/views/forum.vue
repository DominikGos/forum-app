<template>
  <hero />
  <div class="container p-3 mt-5">
    <div class="row gap-5">
      <div class="col-xl-8 d-flex flex-column gap-5">
        <banner
          :imagePath="'../../../public/images/conversation.png'"
          :header="'You can not find an answer?'"
          :paragraph="'Ask question!'"
          :buttonText="'Create thread'"
          :modalComponentName="'createThreadForm'"
        />
        <forums-table />
      </div>
      <div class="d-none col-xl-3 d-xl-flex flex-column gap-5">
        <forums />
        <tags />
      </div>
    </div>
  </div>
</template>

<script>
import hero from "../components/hero.vue";
import banner from "../components/banner.vue";
import tags from "../components/tags.vue"
import forums from '../components/forum/forums.vue';
import modal from '../components/modal.vue';
import forumsTable from '../components/forum/forums-table.vue';

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
};
</script>
