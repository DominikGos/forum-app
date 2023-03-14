<template>
  <div>
    <div class="hero"></div>
    <div class="profile-content container p-4">
      <profile-content>
        <template v-slot:body>
          <form v-if="errors" @submit="update($event)">
            <h3>Edit forum</h3>
            <div class="d-flex justify-content-center mb-5">
              <div class="w-auto position-relative">
                <square-avatar :photo="forum.image" />
                <div class="dropdown avatar-edit-button position-absolute">
                  <button
                    class="btn btn-secondary dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <i class="fa-solid fa-camera"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li class="dropdown-item">
                      <label for="avatar" class="btn btn-primary"> Change image </label>
                    </li>
                    <li v-if="forum.image" class="dropdown-item">
                      <button type="button" class="btn btn-outline-danger">
                        Remove image
                      </button>
                    </li>
                    <input
                      type="file"
                      name="image"
                      class="d-none"
                      id="image"
                      ref="image"
                    />
                  </ul>
                </div>
              </div>
            </div>
            <div class="w-auto position-relative"></div>
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
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
            <!-- <div class="mb-3">
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
            </div> -->
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
import squareAvatar from "../../components/user/square-avatar.vue";

export default {
  name: "forumEdit",
  components: {
    hero,
    profileContent,
    squareAvatar,
  },
  mixins: [validationErrors],
  data() {
    return {
      forum: {
        id: null,
        name: null,
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

    this.setForum(JSON.parse(this.$route.params.forum));
  },
  methods: {
    update(e) {
      e.preventDefault();

      axios
        .post(
          `/forums/${this.forum.id}`,
          { ...this.forum, ...{ _method: "PUT" } },
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        )
        .then((response) => {
          if (response.status == 200) {
            this.$router.push({ name: "forum", params: { id: response.data.forum.id } });
          }
        })
        .catch((e) => {
          this.setErrors(e.response.data.errors);
        });
    },
    setForum(forumData) {
      for (const property in this.forum) {
        this.forum[property] = forumData[property];
      }

      this.forum.image = null; //temporarily
      console.log(this.forum);
    },
  },
};
</script>
