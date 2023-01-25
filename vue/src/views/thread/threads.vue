<template>
  <hero />
  <div class="mt-5 container p-3">
    <div class="row mb-4">
      <div class="col-12">
        <h3>Category name</h3>
        <p class="text-muted">Short description of category.</p>
      </div>
    </div>
    <div class="row justify-content-between">
      <div class="col-lg-3 col-xl-2 d-none d-lg-flex">
        <tags />
      </div>
      <div class="col-lg-8 col-xl-7 d-flex flex-column gap-5">
         <banner
          :imagePath="'../../../public/images/conversation.png'"
          :header="'You can not find an answer?'"
          :paragraph="'Ask question!'"
          :buttonText="'Create thread'"
        />
        <threads-component />
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
import threadsComponent from "../../components/thread/threads.vue"
import Banner from '../../components/banner.vue';

export default {
  name: "threads",
  components: {
    hero,
    avatar,
    tags,
    mostHelpful,
    threadsComponent,
    Banner
  },
};
</script>
