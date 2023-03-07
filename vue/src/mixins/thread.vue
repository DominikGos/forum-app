<script>
export default {
  name: 'thread',
  methods: {
    getThreadsStatistics(threads) {
      let openedThreads = []
      let closedThreads = []

      threads.forEach(thread => {
        switch (thread.isClosed) {
          case true:
            closedThreads.push(thread)
            break;
          case null:
            openedThreads.push(thread)
            break;
        }
      });

      return {
        openedThreadsCount: openedThreads.length,
        closedThreadsCount: closedThreads.length,
      }
    }
  },
}
</script>
