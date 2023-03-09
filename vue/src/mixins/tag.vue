<script>
import axios from 'axios';

export default {
  name: 'tag',
  data() {
    return {
      tags: []
    }
  },
  methods: {
    async setTags() {
      this.tags = await this.fetchTags()
    },
    async fetchTags() {
      try {
        const response = await axios.get('tags')

        return response.data.tags
      } catch (error) {
        return []
      }
    }
  },
}
</script>
