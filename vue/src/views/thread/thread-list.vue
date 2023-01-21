<template>
  <hero />
  <div class="content container p-3">
    <div class="row gap-1 justify-content-evenly">
      <div class="col-lg-2 d-none d-lg-flex">
        <tags />
      </div>
      <div class="col-lg-8 col-xl-6 d-flex flex-column gap-5">
        <div class="d-flex flex-column border rounded-3">
          <div
            class="
              d-flex
              flex-wrap
              border-bottom
              gap-2
              align-items-center
              justify-content-between
              p-3
              background-gray-300
            "
            style="opacity: 0.75"
          >
            <div class="col-lg-7 d-flex align-items-center gap-3 me-4">
              <div>
                <i class="fa-solid fa-check text-success"></i>
                130 Open
              </div>
              <div>
                <i class="fa-regular fa-x text-danger"></i>
                23 Close
              </div>
            </div>
          </div>
          <div class="d-flex flex-column">
            <div
              class="
                d-flex
                border-bottom
                gap-2
                align-items-center
                justify-content-between
                p-3
                bg-white
              "
            >
              <div class="col-lg-7 d-flex gap-3">
                <avatar />
                <div>
                  <h5>How to center div?</h5>
                  <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
                </div>
              </div>
              <div
                class="
                  d-none d-lg-flex
                  col-lg-5
                  gap-3
                  justify-content-end
                  text-muted
                "
              >
                <div>
                  <i class="fa-regular fa-heart"></i>
                  23
                </div>
                <div>
                  <i class="fa-regular fa-comment"></i>
                  54
                </div>
                <div>
                  <i class="fa-regular fa-eye"></i>
                  123
                </div>
              </div>
            </div>
            <div
              class="
                d-flex
                border-bottom
                gap-2
                align-items-center
                justify-content-between
                p-3
                bg-white
              "
            >
              <div class="col-lg-7 d-flex gap-3">
                <avatar :photo="'/public/images/pexels-pixabay-220453.jpg'" />
                <div>
                  <h5>How to center div?</h5>
                  <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
                </div>
              </div>
              <div
                class="
                  d-none d-lg-flex
                  col-lg-5
                  gap-3
                  justify-content-end
                  text-muted
                "
              >
                <div>
                  <i class="fa-regular fa-heart"></i>
                  23
                </div>
                <div>
                  <i class="fa-regular fa-comment"></i>
                  54
                </div>
                <div>
                  <i class="fa-regular fa-eye"></i>
                  123
                </div>
              </div>
            </div>
            <div
              class="
                d-flex
                gap-2
                align-items-center
                justify-content-between
                p-3
                bg-white
              "
            >
              <div class="col-lg-7 d-flex gap-3">
                <avatar />
                <div>
                  <h5>How to center div?</h5>
                  <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
                </div>
              </div>
              <div
                class="
                  d-none d-lg-flex
                  col-lg-5
                  gap-3
                  justify-content-end
                  text-muted
                "
              >
                <div>
                  <i class="fa-regular fa-heart"></i>
                  23
                </div>
                <div>
                  <i class="fa-regular fa-comment"></i>
                  54
                </div>
                <div>
                  <i class="fa-regular fa-eye"></i>
                  123
                </div>
              </div>
            </div>
          </div>
        </div>
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

export default {
  name: "threadList",
  components: {
    hero,
    avatar,
    tags,
    mostHelpful,
  },
};
</script>

<style lang="sass">
</style>
