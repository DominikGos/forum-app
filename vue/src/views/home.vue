<template>
  <home-hero />
  <header class="home-header">
    <h2 class="text-center">Share your thoughts with us.</h2>
    <p class="text-muted text-center mt-3">
      Write, share, subscribe in our community.
    </p>
  </header>
  <div class="container">
    <div class="categories p-3">
      <div class="row gap-4 justify-content-center">
        <div class="category col-sm-5 p-3 ps-5 pe-5 bg-white shadow-sm flex-column gap-2">
          <img src="/public/images/musical-notes.png" width="60" alt="Music.">
          <h3>Music.</h3>
          <p class="text-muted">Lorem ipsum lorem ipsum.</p>
        </div>
        <div class="category col-sm-5 p-3 ps-5 pe-5 bg-white shadow-sm flex-column gap-2">
          <img src="/public/images/game-console.png" width="60" alt="Games.">
          <h3>Games.</h3>
          <p class="text-muted">Lorem ipsum lorem ipsum.</p>
        </div>
        <div class="category col-sm-5 p-3 ps-5 pe-5 bg-white shadow-sm flex-column gap-2">
          <img src="/public/images/workplace.png" width="60" alt="Programming.">
          <h3>Programming.</h3>
          <p class="text-muted">Lorem ipsum lorem ipsum.</p>
        </div>
        <div class="category col-sm-5 p-3 ps-5 pe-5 bg-white shadow-sm flex-column gap-2">
          <img src="/public/images/thought-bubble.png" width="60" alt="Thoughts.">
          <h3>Thoughts.</h3>
          <p class="text-muted">Lorem ipsum lorem ipsum.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="fact-area w-100 bg-info bg-gradient p-2">
    <div class="container">
      <div class="row flex-lg-nowrap justify-content-center justify-content-lg-evenly pt-5 pb-5 gap-5">
        <div class="col-sm-4 col-lg-3 text-white justify-content-center flex-column gap-2 align-items-center text-center">
          <p class="fact-area__header">120</p>
          <p class="fw-bolder fs-4 m-0">Forum threads.</p>
        </div>
        <div class="col-sm-4 col-lg-3 text-white justify-content-center flex-column gap-2 align-items-center text-center">
          <p class="fact-area__header">1420</p>
          <p class="fw-bolder fs-4 m-0">Users on forum.</p>
        </div>
        <div class="col-sm-4 col-lg-3 text-white justify-content-center flex-column gap-2 align-items-center text-center">
          <p class="fact-area__header">421</p>
          <p class="fw-bolder fs-4 m-0">Interesting thoughts.</p>
        </div>
        <div class="col-sm-4 col-lg-3 text-white justify-content-center flex-column gap-2 align-items-center text-center">
          <p class="fact-area__header">120</p>
          <p class="fw-bolder fs-4 m-0">Forum threads.</p>
        </div>
      </div>
    </div>
  </div>
  <questions-and-answers />
  <!-- <div class="p-2 mt-5">
    <div class="container mt-5 bg-white shadow p-4 ps-5 pe-5 pb-5">
      <div class="row justify-content-center">
        <div class="col-1 d-flex justify-content-end">
          <i class="fa-brands fa-laravel fs-1 text-info"></i>
        </div>
        <div class="col-sm-5">
          <h3>Do you have any question?</h3>
          <p class="text-muted fs-5">Just ask us on the forum!</p>
        </div>
        <div class="col-sm-5 d-flex justify-content-end align-items-start">
          <div class="btn btn-primary">Create thread</div>
        </div>
      </div>
    </div>
  </div> -->
</template>

<script>
import homeHero from "../components/home/home-hero.vue";
import questionsAndAnswers from '../components/home/questions-and-answers.vue'

export default {
  name: "home",
  components: {
    homeHero,
    questionsAndAnswers,
  },
};
</script>

<style lang="sass" scoped>
.home-header
  margin-top: 700px

.categories
  margin-top: 80px

  .category
    transition: all .5s
    transition-delay: .2s

  .category:hover
    box-shadow: 0 .8rem 1.3rem rgba(0,0,0,.15) !important
    cursor: pointer

.fact-area
  margin-top: 100px

  .fact-area__header
    font-size: 3.2rem
    margin: 0
    font-weight: bold

</style>
