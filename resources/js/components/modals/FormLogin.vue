<template>
  <v-dialog v-model="dialog" max-width="440px">
    <ValidationObserver ref="obs">
      <v-card class="elevation-12">
        <v-toolbar
          color="primary"
          dark
          flat>
          <v-toolbar-title>{{ formTitle }}</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
          <v-form>
            <VTextFieldWithValidation
              field="username"
              :form-errors="form.errors"
              rules="required"
              v-model="form.username"
              prepend-icon="mdi-account"
              label="Username" />
            <VPasswordFieldWithValidation
              rules="required"
              v-model="form.password"
              prepend-icon="mdi-lock"
              label="Password" />
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            :loading="form.busy"
            @click="login">{{ $t('login') }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </ValidationObserver>
  </v-dialog>
</template>

<script>
import Form from 'vform'
import { ValidationObserver } from 'vee-validate'
import VTextFieldWithValidation from '~/components/inputs/VTextFieldWithValidation'
import VPasswordFieldWithValidation from '~/components/inputs/VPasswordFieldWithValidation'

export default {
  name: 'FormLogin',

  components: {
    ValidationObserver,
    VTextFieldWithValidation,
    VPasswordFieldWithValidation,
  },

  data: () => ({
    dialog: false,
    form: new Form({
      username: '',
      password: '',
    }),
  }),

  computed: {
    formTitle() {
      return 'Login Form';
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
  },

  created() {
    let vm = this;
    this.$eventHub.$on('form-login', function(value) {
      vm.dialog = value;
    });
  },

  beforeDestroy() {
    this.$eventHub.$off('form-login');
  },

  methods: {
    async login() {
      const result = await this.$refs.obs.validate();
      if(result) {
        try {
          // Submit the form.
          const { data } = await this.form.post('/api/login')

          // Save the token.
          this.$store.dispatch('auth/saveToken', {
            token: data.token,
            remember: this.remember
          })

          // Fetch the user.
          await this.$store.dispatch('auth/fetchUser')

          // Redirect home.
          this.$router.push({ name: 'home' })
        } catch(error) {
          console.error(error);
        }
      }
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.clear();
      }, 300);
    },
    clear() {
      this.form.reset();
      this.$nextTick(() => {
        this.$refs.obs.reset();
      });
    }
  }
}
</script>