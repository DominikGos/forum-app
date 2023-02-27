<template>
  <app-table :items="users" :smallPaddingInItem="true">
    <template v-slot:header>
      <h6 class="m-0">Most helpful</h6>
      <p class="text-muted m-0">Last 30 days.</p>
    </template>
    <template #item="item">
      <div class="d-flex align-items-center">
        <avatar style="transform: scale(0.5)" />
        <p class="text-muted m-0">{{ item.firstName }} {{ item.lastName }}</p>
      </div>
    </template>
  </app-table>
</template>

<script>
import appTable from "./table/app-table.vue";
import avatar from "./avatar.vue";

export default {
  name: "mostHelpful",
  components: {
    avatar,
    appTable,
  },
  data() {
    return {
      users: [
        {
          firstName: "User",
          lastName: "Name",
          avatar: null,
        },
        {
          firstName: "User",
          lastName: "Name",
          avatar: null,
        },
      ],
    };
  },
};
</script>
