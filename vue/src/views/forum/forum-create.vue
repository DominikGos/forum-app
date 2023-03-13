<template>
  <div>
    <div class="hero"></div>
    <div class="profile-content container p-4">
      <profile-content>
        <template v-slot:body>
          <form v-if="errors" @submit="create($event)">
            <div class="mb-3">
              <label for="name" class="form-label">Title</label>
              <input
                type="text"
                v-model="forum.name"
                :class="[errors.name.length > 0 ? 'is-invalid' : '', 'form-control']"
                id="name"
              />
              <div v-if="errors.name.length > 0" id="name" class="invalid-feedback">
                <p v-for="error in errors.name" key="error" class="m-0">
                  {{ error }}
                </p>
              </div>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Choose forum image</label>
              <input
                :class="[errors.image.length > 0 ? 'is-invalid' : '', 'form-control']"
                @change="setImage()"
                ref="image"
                type="file"
                id="image"
              />
              <div v-if="errors.image.length > 0" id="image" class="invalid-feedback">
                <p v-for="error in errors.image" key="error" class="m-0">
                  {{ error }}
                </p>
              </div>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Forum description</label>
              <textarea
                :class="[
                  errors.description.length > 0 ? 'is-invalid' : '',
                  'form-control',
                ]"
                v-model="forum.description"
                id="description"
                rows="3"
              ></textarea>
              <div
                v-if="errors.description.length > 0"
                id="description"
                class="invalid-feedback"
              >
                <p v-for="error in errors.description" key="error" class="m-0">
                  {{ error }}
                </p>
              </div>
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
import axios from "axios";
import validationErrors from "../../mixins/validation-errors.vue";

export default {
  name: "forumCreate",
  components: {
    hero,
    profileContent,
  },
  mixins: [validationErrors],
  data() {
    return {
      forum: {
        title: null,
        image: null,
        description: null,
      },
    };
  },
  mounted() {
    this.errors = {
      name: [],
      image: [],
      description: [],
    };
  },
  methods: {
    create(e) {
      e.preventDefault();

      axios
        .post("/forums", this.forum, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.$router.push({ name: "forum", params: { id: response.data.forum.id } });
        })
        .catch((e) => {
          this.setErrors(e.response.data.errors);
          console.log(this.errors);
        });
    },
    setImage() {
      const image = this.$refs.image.files[0];

      this.forum.image = image;
    },
  },
};
</script>
