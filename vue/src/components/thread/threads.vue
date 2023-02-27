<template>
  <app-table :items="threads">
    <template v-slot:header>
      <div class="col-lg-7 d-flex align-items-center gap-3 me-4">
        <div><i class="fa-solid fa-check text-success"></i> 130 Open</div>
        <div><i class="fa-regular fa-x text-danger"></i> 23 Close</div>
      </div>
    </template>
    <template #item="item">
      <div class="col-lg-7 d-flex gap-3">
        <div
          class="avatar rounded-circle overflow-hidden d-flex justify-content-center align-items-center"
        >
          <img src="/public/images/user.png" />
        </div>
        <div>
          <h5>{{ item.title }}</h5>
          <p class="m-0 tex-muted">{{ item.description }}</p>
        </div>
      </div>
      <div class="d-none d-lg-flex col-lg-5 gap-3 justify-content-end text-muted">
        <div><i class="fa-regular fa-heart"></i> 23</div>
        <div><i class="fa-regular fa-comment"></i> 54</div>
      </div>
    </template>
  </app-table>
</template>
<script>
import appTable from "../table/app-table.vue";

export default {
  name: "thread-list",
  components: {
    appTable,
  },
  data() {
    return {
      threads: [
        {
          title: "How to center div?",
          description: "Lorem ipsum lorem ipsum.",
          likes: 10,
          author: {
            userName: "user123",
            avatar: null,
          },
        },
        {
          title: "How to center div?",
          description: "Lorem ipsum lorem ipsum.",
          likes: 10,
          author: {
            userName: "user123",
            avatar: null,
          },
        },
      ],
    };
  },
};
</script>
