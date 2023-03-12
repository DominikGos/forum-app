<template>
  <div>
    <div class="hero"></div>
    <div class="profile-content container p-4">
      <profile-content>
        <template v-slot:body>
          <form>
            <div class="mb-3">
              <label for="name" class="form-label">Title</label>
              <input type="text" class="form-control" id="name" />
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Choose forum image</label>
              <input class="form-control" type="file" id="image" />
            </div>
            <div class="mb-3">
              <label for="forumDescription" class="form-label">Forum description</label>
              <textarea class="form-control" id="forumDescription" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </template>
      </profile-content>
    </div>
  </div>
</template>

<script>
import hero from "../../components/hero.vue";
import profileContent from "../../components/user/profile-content.vue";

export default {
  name: "forumCreate",
  components: {
    hero,
    profileContent,
  },
};
</script>
