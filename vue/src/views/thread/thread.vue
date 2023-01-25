<template>
  <hero />
  <div class="mt-5 container">
    <div class="row justify-content-center gap-3">
      <div class="col-lg-8 d-flex flex-column gap-4">
        <div class="d-flex align-items-center">
          <div style="width: 70px">
            <avatar style="transform: scale(0.75)" />
          </div>
          <div>
            <h6 class="m-0">User Name</h6>
            <p class="m-0 text-muted">
              <i class="fa-regular fa-calendar"></i> February 20 at 9:32 PM
            </p>
          </div>
        </div>
        <div class="d-flex align-items-start align-items-lg-end">
          <h1 class="m-0 ps-2" style="width: 70px">Q:</h1>
          <h4 class="m-0">How to center div without flex?</h4>
        </div>
        <div
          class="d-flex flex-column align-items-start gap-3"
          style="padding-left: 70px !important"
        >
          <p class="text-muted">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in
            tristique quam. Sed at elit turpis. Praesent dignissim erat eu
            aliquet tristique. Integer mauris nibh, finibus vitae feugiat at,
            sodales sed leo. Pellentesque ac mauris id nisi tristique pulvinar
            non in nunc. Morbi luctus tempor orci non fermentum. Vestibulum
            tincidunt efficitur felis, in fermentum sem tempor eleifend. Mauris
            felis ipsum, imperdiet porttitor dui id, imperdiet ornare justo.
            Duis et mi at nisi commodo pharetra id non turpis. Class aptent
            taciti sociosqu ad litora torquent per conubia nostra, per inceptos
            himenaeos. Curabitur dapibus tortor id odio lobortis, vel vestibulum
            erat posuere. Maecenas ullamcorper facilisis molestie. Duis nec
            finibus libero, faucibus faucibus justo. Vestibulum porta ante ac
            accumsan dapibus. Curabitur orci dui, rhoncus eget ipsum eu,
            ullamcorper ornare urna. Proin convallis mollis purus, et viverra mi
            consequat nec. Curabitur mauris sapien, mattis ut posuere sit amet,
            ullamcorper in purus. Donec accumsan justo quis risus rutrum, et
            cursus risus imperdiet. Integer cursus volutpat arcu, rhoncus
            interdum orci pulvinar vitae. Donec rhoncus at lectus sit amet
            tristique. Morbi auctor odio quis faucibus hendrerit. Aliquam quis
            imperdiet lacus. Nam tincidunt interdum sapien. Cras feugiat sed
            orci ut facilisis.
          </p>
          <hr class="w-100" />
          <button class="btn btn-primary">Reply</button>
        </div>
        <comment :isAccepted="true" />
        <h4 class="mt-5">Replies</h4>
        <comment-form />
        <comment :isAccepted="false" />
      </div>
      <div class="col-lg-3 d-none d-lg-flex flex-column gap-5">
        <categories />
        <tags />
      </div>
    </div>
  </div>
</template>

<script>
import avatar from "../../components/avatar.vue";
import categories from "../../components/categories.vue";
import CommentForm from '../../components/comment/comment-form.vue';
import comment from "../../components/comment/comment.vue";
import hero from "../../components/hero.vue";
import tags from "../../components/tags.vue";

export default {
  components: { hero, avatar, tags, comment, categories, CommentForm },
  name: "thread",
};
</script>
