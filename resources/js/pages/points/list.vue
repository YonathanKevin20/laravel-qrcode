<template>
  <v-row>
    <v-col cols="12">
      <v-data-table
        :headers="headers"
        :items="items"
        :search="search"
        :loading="loading" loading-text="Loading... Please wait"
        class="elevation-1">
        <template v-slot:top>
          <v-container>
            <v-row align="center">
              <v-col cols="3">
                <v-dialog v-model="dialog" max-width="700px">
                  <template v-slot:activator="{ on }">
                    <v-btn color="purple" dark v-on="on">{{ $t('import') }}</v-btn>
                  </template>
                  <ValidationObserver ref="obs">
                    <v-card>
                      <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                      </v-card-title>
                      <v-card-text>
                        <v-container>
                          <v-row>
                            <v-col cols="6">
                              <VTextFieldWithValidation
                                rules="required|numeric"
                                v-model="form.qty"
                                label="Point(s)" />
                            </v-col>
                            <v-col cols="6">
                              <VSelectWithValidation
                                rules="required"
                                v-model="form.info"
                                :items="infoOptions"
                                label="Info" />
                            </v-col>
                          </v-row>
                        </v-container>
                      </v-card-text>
                      <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn
                          color="error"
                          @click="close">{{ $t('cancel') }}
                        </v-btn>
                        <v-btn
                          color="success"
                          @click="save">{{ $t('save') }}
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </ValidationObserver>
                </v-dialog>
              </v-col>
              <v-col offset="6" cols="3">
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  hide-details>
                </v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </template>
        <template v-slot:item.action="{ item }">
          <v-btn x-small fab color="primary">
            <v-icon
              small
              @click="addPoint(item)">mdi-plus
          </v-icon>
          </v-btn>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
import Form from 'vform'
import { ValidationObserver } from "vee-validate"
import VTextFieldWithValidation from '~/components/inputs/VTextFieldWithValidation'
import VSelectWithValidation from '~/components/inputs/VSelectWithValidation'

export default {
  components: {
    ValidationObserver,
    VTextFieldWithValidation,
    VSelectWithValidation,
  },

  mounted() {
    this.getData();
  },

  data: () => ({
    infoOptions: ['tambah', 'bonus'],
    dialog: false,
    loading: true,
    search: '',
    method: 'store',
    headers: [
      { text: 'Name', value: 'name' },
      { text: 'Grade', value: 'grade' },
      { text: 'Point(s)', value: 'qty' },
      { text: 'Actions', value: 'action', sortable: false, align: 'center' },
    ],
    items: [],
    form: new Form({
      child_id: '',
      name: '',
      qty: '',
      info: '',
    }),
  }),

  computed: {
    formTitle() {
      return this.method === 'store' ? this.$t('add_points')+' to '+this.form.name : this.$t('edit')
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
  },

  methods: {
    async getData() {
      this.loading = true;
      try {
        const response  = await this.form.get('/api/point');
        this.items = response.data;
        this.loading = false;
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    },
    async save() {
      const result = await this.$refs.obs.validate();
      if(result) {
        if(this.method == 'store') {
            this.store();
        }
      }
    },
    async store() {
      try {
        const response = await this.form.post('/api/point');
        this.getData();
        this.close();
        this.$toast.fire({
          type: 'success',
          title: 'Created'
        });
        console.log(response);
      } catch(error) {
        console.error(error);
      }
    },
    addPoint(item) {
      this.dialog = true;
      this.method = 'store';
      this.form.child_id = item.child_id;
      this.form.name = item.name;
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.clear();
        this.method = 'store';
      }, 300);
    },
    clear() {
      this.form.child_id = this.form.qty = this.form.info = '';
      this.$nextTick(() => {
        this.$refs.obs.reset();
      });
    }
  }
}
</script>