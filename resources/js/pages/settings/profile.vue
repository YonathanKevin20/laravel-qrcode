<template>
  <v-card
    class="mx-auto"
    tile>
    <v-card-title>{{ $t('your_info') }}</v-card-title>
    <v-card-text>
      <v-container>
        <ValidationObserver ref="obs">
          <v-form>
            <v-alert :value="form.successful" type="success">{{ $t('info_updated') }}</v-alert>
            <v-row>
              <v-col offset="1" cols="10">
                <VTextFieldWithValidation
                  rules="required"
                  v-model="form.name"
                  :label="$t('name')" />
              </v-col>
            </v-row>
            <v-row>
              <v-col offset="1" cols="10">
                <VTextFieldWithValidation
                  rules="email"
                  v-model="form.email"
                  :label="$t('email')" />
              </v-col>
            </v-row>
          </v-form>
        </ValidationObserver>
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-container class="d-flex justify-center">
        <v-btn
          color="success"
          :loading="form.busy"
          @click="update">{{ $t('update') }}
        </v-btn>
      </v-container>
    </v-card-actions>
  </v-card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import { ValidationObserver } from 'vee-validate'
import VTextFieldWithValidation from '~/components/inputs/VTextFieldWithValidation'

export default {
  components: {
    ValidationObserver,
    VTextFieldWithValidation
  },

  scrollToTop: false,

  data: () => ({
    form: new Form({
      name: '',
      email: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created() {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update() {
      const result = await this.$refs.obs.validate();
      if(result) {
        const { data } = await this.form.patch('/api/settings/profile')
        this.$store.dispatch('auth/updateUser', { user: data })
      }
    }
  }
}
</script>
