<template>
  <ValidationProvider :name="$attrs.label" :rules="rules">
    <v-text-field
      v-if="formErrors"
      slot-scope="{ errors, valid }"
      v-model="innerValue"
      :error-messages="formErrors.has($attrs.field) ? formErrors.get($attrs.field) : errors"
      v-bind="$attrs"
      v-on="$listeners">
    </v-text-field>
    <v-text-field
      v-else
      slot-scope="{ errors, valid }"
      v-model="innerValue"
      :error-messages="errors"
      v-bind="$attrs"
      v-on="$listeners">
    </v-text-field>
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from 'vee-validate/dist/vee-validate.full';

export default {
  components: {
    ValidationProvider
  },

  props: {
    rules: {
      type: [Object, String],
      default: ''
    },
    // must be included in props
    value: {
      type: null
    },
    formErrors: {
      type: Object
    }
  },

  data: () => ({
    innerValue: ''
  }),

  created() {
    if(this.value) {
      this.innerValue = this.value;
    }
  },

  watch: {
    // Handles internal model changes.
    innerValue(newVal) {
      this.$emit('input', newVal);
    },
    // Handles external model changes.
    value(newVal) {
      this.innerValue = newVal;
    }
  }
}
</script>
