<template>
  <app-table :items="forums">
    <template v-slot:header>
      <div class="col-7">Forum</div>
      <div class="col-lg-2 d-none d-lg-block">Topics</div>
      <div class="col-lg-2 d-none d-lg-block">Last post</div>
    </template>
    <template #item="item">
      <router-link :to="{name: 'forum', params: {id: item.id} }" class="col-2 d-flex justify-content-center">
        <img :src="item.image" width="25" alt="forum image"/>
      </router-link>
      <div class="col-9 col-lg-5">
        <h5>{{ item.name }}</h5>
        <p class="m-0 tex-muted">{{ item.description }}</p>
      </div>
      <div class="col-lg-2 d-none d-lg-block">
        <p class="m-0">{{ item.threadCount }}</p>
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
  props: {
    forums: Array
  },
  components: {
    appTable,
  },
};
</script>
