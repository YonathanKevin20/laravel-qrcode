<template>
  <v-dialog v-model="dialog" max-width="700px">
    <ValidationObserver ref="obs">
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <VPasswordFieldWithValidation
                  rules="required"
                  v-model="form.password"
                  label="Password" />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn
            class="white--text"
            color="red"
            @click="close">{{ $t('cancel') }}
          </v-btn>
          <v-btn
            class="white--text"
            color="green"
            @click="update">{{ $t('save') }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </ValidationObserver>
  </v-dialog>
</template>

<style>
  a:hover {
    text-decoration: none;
  }
</style>

<script>
import Form from 'vform'
import { ValidationObserver } from "vee-validate"
import VPasswordFieldWithValidation from '~/components/inputs/VPasswordFieldWithValidation'

export default {
  name: 'FormChangePassword',

  components: {
    ValidationObserver,
    VPasswordFieldWithValidation,
  },

  props: ['id'],

  data: () => ({
    dialog: false,
    import_file: [],
    form: new Form({
      password: '',
    }),
  }),

  computed: {
    formTitle() {
      return 'Change Password'
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
  },

  created() {
    let vm = this;
    this.$eventHub.$on('form-change-password-'+this.id, function(value) {
      vm.dialog = value;
    });
  },

  beforeDestroy() {
    this.$eventHub.$off('form-change-password');
  },

  methods: {
    async update() {
      const result = await this.$refs.obs.validate();
      if(result) {
        const { data } = await this.form.patch(base_api+'/user/update-password/'+this.id);
        if(data.success) {
          this.close();
          this.$toast.fire({
            type: 'success',
            title: 'Password Updated'
          });
        }
        else {
          this.$toast.fire({
            type: 'danger',
            title: 'Failed'
          });
          console.log(data.console);
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
    },
  }
}
</script>