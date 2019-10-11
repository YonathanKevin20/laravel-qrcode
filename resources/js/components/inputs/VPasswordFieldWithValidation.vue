<template>
  <ValidationProvider :name="$attrs.label" :rules="rules">
    <v-text-field
      slot-scope="{ errors, valid }"
      v-model="innerValue"
      :append-icon="show ? 'visibility' : 'visibility_off'"
      :error-messages="errors"
      :type="show ? 'text' : 'password'"
      counter
      v-bind="$attrs"
      v-on="$listeners"
      @click:append="show = !show">
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
    }
  },
  data: () => ({
    show: false,
    innerValue: ''
  }),
  watch: {
    // Handles internal model changes.
    innerValue(newVal) {
      this.$emit('input', newVal);
    },
    // Handles external model changes.
    value(newVal) {
      this.innerValue = newVal;
    }
  },
  created() {
    if(this.value) {
      this.innerValue = this.value;
    }
  }
}
</script>
