<template>
  <ValidationProvider :name="$attrs.name" :rules="rules">
    <v-radio-group
      slot-scope="{ errors }"
      v-model="innerValue"
      :error-messages="errors"
      row>
      <v-radio
        v-for="(row, index) in $attrs.label"
        :key="index"
        :label="row.label"
        :value="row.value"
        :class="'mb-0'" />
    </v-radio-group>
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
    innerValue: ''
  }),
  watch: {
    // Handles internal model changes.
    innerValue (newVal) {
      this.$emit('input', newVal);
    },
    // Handles external model changes.
    value (newVal) {
      this.innerValue = newVal;
    }
  },
  created () {
    if (this.value) {
      this.innerValue = this.value;
    }
  }
}
</script>

<style>
  label.v-label {
    margin-bottom: 0;
  }
</style>