<template>
  <hero />
  <div class="content container p-3">
    <div class="row gap-1 justify-content-evenly">
      <div class="col-lg-2 d-none d-lg-flex">
        <tags />
      </div>
      <div class="col-lg-8 col-xl-6 d-flex flex-column gap-5">
        <thread-list-component />
        <nav aria-label="...">
          <ul class="pagination">
            <li class="page-item disabled">
              <span class="page-link">Previous</span>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active" aria-current="page">
              <span class="page-link">2</span>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>
      </div>
      <div class="col-xl-3 d-none d-xl-flex align-items-start">
        <most-helpful />
      </div>
    </div>
  </div>
</template>

<script>
import hero from "../../components/hero.vue";
import avatar from "../../components/avatar.vue";
import tags from "../../components/tags.vue";
import mostHelpful from "../../components/most-helpful.vue";
import threadListComponent from "../../components/thread/thread-list.vue"

export default {
  name: "threadList",
  components: {
    hero,
    avatar,
    tags,
    mostHelpful,
    threadListComponent
  },
};
</script>

<style lang="sass">
</style>
