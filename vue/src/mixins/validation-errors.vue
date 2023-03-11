<script>
import camelCase from "camelcase";

export default {
  name: 'validationErrors',
  data() {
    return {
      errors: null
    }
  },
  methods: {
    setErrors(errors) {
      this.errors = this.resetErrors(this.errors)

      for (let field in errors) {
        field = camelCase(field)
        
        this.errors[field] = errors[field];
      }
    },

    resetErrors(errors) {
      Object.keys(errors).forEach((property) => {
        errors[property] = [];
      });

      return errors
    },
  },
}
</script>
