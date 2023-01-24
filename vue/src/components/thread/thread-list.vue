<template>
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
        <div><i class="fa-solid fa-check text-success"></i> 130 Open</div>
        <div><i class="fa-regular fa-x text-danger"></i> 23 Close</div>
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
          <div
            class="
              avatar
              rounded-circle
              overflow-hidden
              d-flex
              justify-content-center
              align-items-center
            "
          >
            <img src="/public/images/user.png" />
          </div>
          <div>
            <h5>How to center div?</h5>
            <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
          </div>
        </div>
        <div
          class="d-none d-lg-flex col-lg-5 gap-3 justify-content-end text-muted"
        >
          <div><i class="fa-regular fa-heart"></i> 23</div>
          <div><i class="fa-regular fa-comment"></i> 54</div>
          <div><i class="fa-regular fa-eye"></i> 123</div>
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
          <div
            class="
              background-gray-300
              avatar
              rounded-circle
              overflow-hidden
              d-flex
              justify-content-center
              align-items-center
            "
          >
            <img src="/public/images/pexels-pixabay-220453.jpg" />
          </div>
          <div>
            <h5>How to center div?</h5>
            <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
          </div>
        </div>
        <div
          class="d-none d-lg-flex col-lg-5 gap-3 justify-content-end text-muted"
        >
          <div><i class="fa-regular fa-heart"></i> 23</div>
          <div><i class="fa-regular fa-comment"></i> 54</div>
          <div><i class="fa-regular fa-eye"></i> 123</div>
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
          <div
            class="
              avatar
              rounded-circle
              overflow-hidden
              d-flex
              justify-content-center
              align-items-center
            "
          >
            <img src="/public/images/user.png" />
          </div>
          <div>
            <h5>How to center div?</h5>
            <p class="m-0 tex-muted">Lorem ipsum lorem ipsum.</p>
          </div>
        </div>
        <div
          class="d-none d-lg-flex col-lg-5 gap-3 justify-content-end text-muted"
        >
          <div><i class="fa-regular fa-heart"></i> 23</div>
          <div><i class="fa-regular fa-comment"></i> 54</div>
          <div><i class="fa-regular fa-eye"></i> 123</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "thread-list",
};
</script>
