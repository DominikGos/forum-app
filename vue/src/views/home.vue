<template>
  <main>
    <hello-world />
  </main>
</template>

<script>
    import helloWorld from '../components/HelloWorld.vue'

    export default {
        name: 'home',
        components: {
            helloWorld
        }
    }

</script>
