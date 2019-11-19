<template>
  <v-card
    class="mx-auto"
    tile>
    <v-card-title>{{ $t('your_password') }}</v-card-title>
    <v-card-text>
      <v-container>
        <ValidationObserver ref="obs">
          <v-form>
            <v-alert :value="form.successful" type="success">{{ $t('password_updated') }}</v-alert>
            <v-row>
              <v-col offset="1" cols="10">
                <VPasswordFieldWithValidation
                  rules="required|min:8"
                  v-model="form.password"
                  :vid="'password'"
                  :label="$t('new_password')" />
              </v-col>
            </v-row>
            <v-row>
              <v-col offset="1" cols="10">
                <VPasswordFieldWithValidation
                  rules="required|confirmed:password"
                  v-model="form.password_confirmation"
                  :label="$t('confirm_password')" />
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
import { ValidationObserver } from 'vee-validate'
import VPasswordFieldWithValidation from '~/components/inputs/VPasswordFieldWithValidation'

export default {
  components: {
    ValidationObserver,
    VPasswordFieldWithValidation
  },

  scrollToTop: false,

  data: () => ({
    form: new Form({
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async update() {
      const result = await this.$refs.obs.validate();
      if(result) {
        await this.form.patch('/api/settings/password');
        this.form.reset();
        this.$refs.obs.reset();
      }
    }
  }
}
</script>
