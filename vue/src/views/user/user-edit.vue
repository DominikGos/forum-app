<template>
  <profile-content>
    <template v-slot:body>
      <form @submit="update($event)">
        <div class="d-flex justify-content-center mb-5">
          <div class="w-auto position-relative">
            <square-avatar :photo="user.avatarPath" />
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
                <li>
                  <label for="avatar" class="dropdown-item btn"> Change avatar </label>
                </li>
                <li>
                  <div class="dropdown-item">
                    Delete avatar
                    <input type="checkbox" v-model="deleteAvatar" />
                  </div>
                </li>
                <input
                  type="file"
                  @change="sendAvatar($event)"
                  name="avatar"
                  class="d-none"
                  id="avatar"
                  ref="avatar"
                />
              </ul>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="login" class="form-label">Login</label>
          <input
            v-model="user.login"
            type="text"
            :class="[errors.login.length > 0 ? 'is-invalid' : '', 'form-control']"
            id="login"
          />
          <div v-if="errors.login.length > 0" id="login" class="invalid-feedback">
            <p v-for="error in errors.login" key="error" class="m-0">
              {{ error }}
            </p>
          </div>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input
            v-model="user.email"
            type="email"
            :class="[errors.email.length > 0 ? 'is-invalid' : '', 'form-control']"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
          />
          <div v-if="errors.email.length > 0" id="email" class="invalid-feedback">
            <p v-for="error in errors.email" key="error" class="m-0">
              {{ error }}
            </p>
          </div>
        </div>
        <div class="d-flex gap-2 mb-3">
          <div class="w-50">
            <label for="firstName" class="form-label">First name</label>
            <input
              v-model="user.firstName"
              type="text"
              :class="[errors.firstName.length > 0 ? 'is-invalid' : '', 'form-control']"
              id="firstName"
              required
            />
            <div
              v-if="errors.firstName.length > 0"
              id="firstName"
              class="invalid-feedback"
            >
              <p v-for="error in errors.firstName" key="error" class="m-0">
                {{ error }}
              </p>
            </div>
          </div>
          <div class="w-50">
            <label for="lastName" class="form-label">Last name</label>
            <input
              v-model="user.lastName"
              type="text"
              :class="[errors.lastName.length > 0 ? 'is-invalid' : '', 'form-control']"
              id="lastName"
              required
            />
            <div v-if="errors.lastName.length > 0" id="lastName" class="invalid-feedback">
              <p v-for="error in errors.lastName" key="error" class="m-0">
                {{ error }}
              </p>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="description" class="form-label"
            >Example textarea</label
          >
          <textarea
            :class="[errors.description.length > 0 ? 'is-invalid' : '', 'form-control']"
            id="description"
            rows="3"
            v-model="user.description"
          ></textarea>
          <div v-if="errors.description.length > 0" id="description" class="invalid-feedback">
            <p v-for="error in errors.description" key="error" class="m-0">
              {{ error }}
            </p>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </template>
  </profile-content>
</template>

<script>
import profileContent from "../../components/user/profile-content.vue";
import userMixin from "../../mixins/user.vue";
import squareAvatar from "../../components/user/square-avatar.vue";
import axios from "axios";

export default {
  name: "userEdit",
  mixins: [userMixin],
  props: {
    propUser: Object,
  },
  components: {
    profileContent,
    squareAvatar,
  },
  data() {
    return {
      avatar: null,
      deleteAvatar: null,
      errors: {
        login: [],
        email: [],
        firstName: [],
        lastName: [],
        description: [],
      },
    };
  },
  async mounted() {
    this.user = this.propUser;

    if (this.user.id == null) {
      await this.setUser(this.$route.params.id);
    }
  },
  methods: {
    async update(e) {
      e.preventDefault();

      const mappedUser = {
        login: this.user.login,
        first_name: this.user.firstName,
        last_name: this.user.lastName,
        email: this.user.email,
        description: this.user.description,
      };

      axios
        .put(`users/${this.$store.state.user.id}`, mappedUser)
        .then((response) => {
          if (response.status == 200) {
            this.$store.commit("updateUser", {
              ...this.$store.state.user,
              ...response.data.user,
            });

            this.$router.push({ name: "user", params: { id: response.data.user.id } });
          }
        })
        .catch((e) => {
          this.errors = this.setErrors(e.response.data.errors);

          console.log(this.errors);
        });
    },

    async sendAvatar(e) {
      const avatar = this.$refs.avatar.files[0];
    },

    setErrors(errors) {
      let errorStructure = {
        login: [],
        email: [],
        firstName: [],
        lastName: [],
        description: [],
      };

      for (const field in errors) {
        switch (field) {
          case "login":
            errorStructure.login = errorStructure.login.concat(errors[field]);
            break;
          case "email":
            errorStructure.email = errorStructure.email.concat(errors[field]);
            break;
          case "first_name":
            errorStructure.firstName = errorStructure.firstName.concat(errors[field]);
            break;
          case "last_name":
            errorStructure.lastName = errorStructure.lastName.concat(errors[field]);
          case "description":
            errorStructure.description = errorStructure.description.concat(errors[field]);
            break;
        }
      }

      return errorStructure;
    },
  },
};
</script>

<style lang="sass" scoped>
.avatar-edit-button
  bottom: -10px
  right: -10px
  z-index: 1100
</style>
