<template>
  <div class="p-3 bg-white shadow-sm rounded-3 d-flex flex-column gap-4">
    <div class="d-flex justify-content-between">
      <h4>User replies.</h4>
      <select class="form-select w-auto" aria-label="Default select example">
        <option selected>Sort by</option>
        <option value="1">Oldest</option>
        <option value="2">Newest</option>
      </select>
    </div>
    <comment />
    <comment />
    <comment />
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
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
  </div>
</template>

<script>
import comment from "../../components/comment/comment.vue";
export default {
  components: { comment },
  name: "userReplies",
};
</script>
