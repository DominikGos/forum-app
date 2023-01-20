<template>
  <hero />
  <div class="content container p-3">
    <div class="row gap-5">
      <div class="col-xl-8 d-flex flex-column gap-5">
        <banner
          :imagePath="'../../../public/images/conversation.png'"
          :header="'You can not find an answer?'"
          :paragraph="'Ask question!'"
          :buttonText="'Create thread'"
        />
        <div class="d-flex flex-column border rounded-3">
          <div
            class="
              d-flex
              border-bottom
              gap-2
              align-items-center
              justify-content-between
              p-3
              background-gray-300
            "
            style="opacity: .75"
          >
            <div class="col-2">Forum</div>
            <div class="d-none d-lg-block col-lg-5">Category</div>
            <div class="col-lg-2 d-none d-lg-block">Topics</div>
            <div class="col-lg-2 d-none d-lg-block">Last post</div>
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
              <div class="col-2 d-flex justify-content-center">
                <img src="/public/images/musical-notes.png" width="25" />
              </div>
              <div class="col-9 col-lg-5">
                <h5>music</h5>
                <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
              </div>
              <div class="col-lg-2 d-none d-lg-block">
                <p class="m-0">120</p>
              </div>
              <div class="col-lg-2 d-none d-lg-block">
                <p class="m-0">1 year ago</p>
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
              <div class="col-2  d-flex justify-content-center">
                <img src="/public/images/game-console.png" width="25" />
              </div>
              <div class="col-9 col-lg-5">
                <h5>Games</h5>
                <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
              </div>
              <div class="col-lg-2 d-none d-lg-block">
                <p class="m-0">150</p>
              </div>
              <div class="col-lg-2 d-none d-lg-block">
                <p class="m-0">1 year ago</p>
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
              <div class="col-2 d-flex justify-content-center">
                <img src="/public/images/musical-notes.png" width="25" />
              </div>
              <div class="col-9 col-lg-5">
                <h5>music</h5>
                <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
              </div>
              <div class="col-lg-2 d-none d-lg-block">
                <p class="m-0">121</p>
              </div>
              <div class="col-lg-2 d-none d-lg-block">
                <p class="m-0">1 year ago</p>
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
              <div class="col-2 d-flex justify-content-center">
                <img src="/public/images/game-console.png" width="25" />
              </div>
              <div class="col-9 col-lg-5">
                <h5>Games</h5>
                <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
              </div>
              <div class="col-lg-2 d-none d-lg-block">
                <p class="m-0">130</p>
              </div>
              <div class="col-lg-2 d-none d-lg-block">
                <p class="m-0">2 year ago</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-none col-xl-3 d-xl-flex flex-column gap-5">
        <div class="d-flex flex-column gap-2">
          <h3>Categories</h3>
          <div
            class="
              d-flex
              border-bottom
              gap-2
              align-items-center
              justify-content-between
              p-2
            "
          >
            <img src="/public/images/musical-notes.png" width="25" />
            <p class="m-0">music</p>
            <div class="rounded-circle ps-2 pe-2 p-1 background-gray-300">
              24
            </div>
          </div>
          <div
            class="
              d-flex
              border-bottom
              gap-2
              align-items-center
              justify-content-between
              p-2
            "
          >
            <img src="/public/images/game-console.png" width="25" />
            <p class="m-0">games</p>
            <div class="rounded-circle ps-2 pe-2 p-1 background-gray-300">
              14
            </div>
          </div>
          <div
            class="
              d-flex
              border-bottom
              gap-2
              align-items-center
              justify-content-between
              p-2
            "
          >
            <img src="/public/images/workplace.png" width="25" />
            <p class="m-0">programming</p>
            <div class="rounded-circle ps-2 pe-2 p-1 background-gray-300">
              14
            </div>
          </div>
          <div
            class="
              d-flex
              border-bottom
              gap-2
              align-items-center
              justify-content-between
              p-2
            "
          >
            <img src="/public/images/game-console.png" width="25" />
            <p class="m-0">games</p>
            <div class="rounded-circle ps-2 pe-2 p-1 background-gray-300">
              14
            </div>
          </div>
        </div>
        <tags />
      </div>
    </div>
  </div>
</template>

<script>
import hero from "../components/hero.vue";
import banner from "../components/banner.vue";
import tags from "../components/tags.vue"

export default {
  name: "forum",
  components: {
    hero,
    banner,
    tags,
  },
};
</script>

<style lang="sass">
.content
  margin-top: 350px !important

.background-gray-300 //create color object
  background-color: #dee2e6
.background-gray-200
  background-color: #f8f9fa
</style>
