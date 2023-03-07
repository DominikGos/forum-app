<template>
  <app-table :items="threads" v-if="delayIsOver">
    <template v-slot:header>
      <div class="col-lg-7 d-flex align-items-center gap-3 me-4">
        <div><i class="fa-solid fa-check text-success"></i> {{ threadsStatistics.openedThreadsCount }} Open</div>
        <div><i class="fa-regular fa-x text-danger"></i> {{ threadsStatistics.closedThreadsCount }} Close</div>
      </div>
    </template>
    <template #item="item">
      <router-link :to="{ name: 'thread', params: {id: item.id} }" class="col-lg-7 d-flex gap-3 text-decoration-none">
        <div
          class="avatar rounded-circle overflow-hidden d-flex justify-content-center align-items-center"
        >
          <img v-if="item.user.avatarPath" :src="item.user.avatarPath" alt="avatar"/>
          <img v-else src="/public/images/user.png" alt="avatar"/>
        </div>
        <div>
          <h5 class="text-dark">{{ item.title }}</h5>
          <p class="m-0 text-secondary d-none d-sm-block">{{ item.description }}</p>
        </div>
      </router-link>
      <div class="d-none d-lg-flex col-lg-5 gap-3 justify-content-end text-muted">
        <div><i class="fa-regular fa-heart"></i> {{ item.likes }} </div>
        <div><i class="fa-regular fa-comment"></i> {{ item.replyCount }} </div>
      </div>
    </template>
  </app-table>
</template>
<script>
import appTable from "../table/app-table.vue";
import threadMixin from '../../mixins/thread.vue';

export default {
  name: "thread-list",
  props: {
    threads: Array,
  },
  mixins: [
    threadMixin,
  ],
  components: {
    appTable,
  },
  data() {
    return {
      threadsStatistics: [],
      delay: 1500,
      delayIsOver: false,
    }
  },
  mounted() {
    setTimeout(() => {
      this.threadsStatistics = this.getThreadsStatistics(this.threads)

      this.delayIsOver = true
    }, this.delay);
  },
};
</script>
