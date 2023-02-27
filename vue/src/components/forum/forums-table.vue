<template>
  <app-table :items="forums">
    <template v-slot:header>
      <div class="col-7">Forum</div>
      <div class="col-lg-2 d-none d-lg-block">Topics</div>
      <div class="col-lg-2 d-none d-lg-block">Last post</div>
    </template>
    <template #item="item">
      <div class="col-2 d-flex justify-content-center">
        <img src="/public/images/musical-notes.png" width="25" />
      </div>
      <div class="col-9 col-lg-5">
        <h5>{{ item.name }}</h5>
        <p class="m-0 tex-muted">{{ item.description }}</p>
      </div>
      <div class="col-lg-2 d-none d-lg-block">
        <p class="m-0">121</p>
      </div>
      <div class="col-lg-2 d-none d-lg-block">
        <p class="m-0">1 year ago</p>
      </div>
    </template>
  </app-table>
</template>

<script>
import appTable from "../table/app-table.vue";

export default {
  name: "forumsTable",
  components: {
    appTable,
  },
  data() {
    return {
      forums: [
        {
          name: "Test forum",
          description: "test desc",
          image: null,
        },
        {
          name: "Test forum",
          description: "test desc",
          image: null,
        },
        {
          name: "Test forum",
          description: "test desc",
          image: null,
        },
      ],
    };
  },
};
</script>
