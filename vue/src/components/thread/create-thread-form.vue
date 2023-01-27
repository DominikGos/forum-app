<template>
  <form action="">
    <h3>Create thread.</h3>
    <div class="mb-3">
      <label for="title" class="form-label">
        Title
      </label>
      <input
        v-model="title"
        type="text"
        class="form-control"
        id="title"
      />
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">
        Description
      </label>
      <ckeditor
        @input="log()"
        id="description"
        :editor="editor"
        v-model="editorData"
        :config="editorConfig"
      ></ckeditor>
    </div>
    <div class="mb-3">
      <button type="submit" class="btn btn-primary">Send</button>
    </div>
  </form>
</template>

<script>
import Editor from 'ckeditor5-custom-build/build/ckeditor';

export default {
  name: "createThread",
  data() {
    return {
      title: '',
      editor: Editor,
      editorData: "<p>Describe your problem.</p>",
      editorConfig: {
        // The configuration of the editor.
      },
    };
  },
  methods: {
    log( ) {
      console.log(this.editorData)
    }
  },
};
</script>
