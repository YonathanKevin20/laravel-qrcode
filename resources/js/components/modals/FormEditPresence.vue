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
              <v-col cols="6">
                <v-menu
                  ref="menu"
                  v-model="menuDate"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="290px">
                  <template v-slot:activator="{ on }">
                    <VTextFieldWithValidation
                      rules="required"
                      v-model="form.date"
                      label="Date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-on="on" />
                  </template>
                  <v-date-picker
                    ref="picker"
                    color="blue"
                    v-model="form.date"
                    :allowed-dates="allowedDates"
                    :max="new Date().toISOString().substr(0, 10)"
                    min="2019-01-01"
                    @change="saveDate">
                  </v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="6">
                <VTextFieldWithValidation
                  rules="required"
                  v-model="form.time"
                  v-mask="mask"
                  placeholder="hh:mm:ss"
                  label="Time" />
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

<script>
import Form from 'vform'
import { ValidationObserver } from 'vee-validate'
import { mask } from 'vue-the-mask'
import VTextFieldWithValidation from '~/components/inputs/VTextFieldWithValidation'

export default {
  name: 'FormEditPresence',

  directives: {
    mask,
  },

  components: {
    ValidationObserver,
    VTextFieldWithValidation,
  },

  data: () => ({
    dialog: false,
    mask: '##:##:##',
    datetime: '',
    menuDate: false,
    form: new Form({
      id: '',
      date: '',
      time: '',
    }),
  }),

  computed: {
    formTitle() {
      return 'Edit Presence - '+this.datetime;
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
    menuDate(val) {
      val
    },
  },

  created() {
    let vm = this;
    let epoch = '';
    this.$eventHub.$on('form-edit-presence', function(item, value) {
      if(item.check_in != 0) {
        epoch = new Date(item.check_in * 1000);
        vm.form.date = vm.humanDate(epoch);
        vm.form.time = vm.humanTime(epoch);
      }
      vm.form.id = item.id;
      vm.datetime = item.datetime;
      vm.dialog = value;
    });
  },

  beforeDestroy() {
    this.$eventHub.$off('form-edit-presence');
  },

  methods: {
    async update() {
      const result = await this.$refs.obs.validate();
      if(result) {
        try {
          const response = await this.form.patch(base_api+'/presence/'+this.$route.params.child_id);
          this.$eventHub.$emit('refresh-table', 'table-detail-presence');
          this.close();
          this.$toast.fire({
            type: 'success',
            title: 'Updated'
          });
          console.log(response);
        } catch(error) {
          console.error(error);
          this.$toast.fire({
            type: 'error',
            title: 'Failed'
          });
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
    saveDate(date) {
      this.$refs.menu.save(date);
    },
    allowedDates(val) {
      let date = new Date(val);
      if(date.getDay() == 0) { // only Sunday
        return true;
      }
      else {
        return false;
      }
    }
  }
}
</script>