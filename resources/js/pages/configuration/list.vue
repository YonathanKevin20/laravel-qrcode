<template>
  <v-row>
    <v-col cols="12">
      <v-data-table
        :headers="headers"
        :items="items"
        :search="search"
        :loading="loading"
        loading-text="Loading... Please wait"
        class="elevation-1">
        <template v-slot:top>
          <v-container>
            <v-row align="center">
              <v-col cols="3">
                <v-dialog v-model="dialog" max-width="700px">
                  <ValidationObserver ref="obs">
                    <v-card>
                      <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                      </v-card-title>
                      <v-card-text>
                        <v-container>
                          <v-row v-if="method === 'update'">
                            <v-col cols="12">
                              <VTextFieldWithValidation
                                v-model="form.parameter"
                                readonly
                                label="Parameter" />
                            </v-col>
                          </v-row>
                          <v-row>
                            <v-col cols="6">
                              <VTextFieldWithValidation
                                v-if="form.parameter === 'start_time' || form.parameter === 'end_time'"
                                rules="required"
                                v-model="form.value"
                                v-mask="mask"
                                placeholder="hh:mm:ss"
                                label="Value" />                              
                              <VTextFieldWithValidation
                                v-else
                                rules="required"
                                v-model="form.value"
                                label="Value" />
                            </v-col>
                            <v-col cols="6">
                              <VTextFieldWithValidation
                                v-model="form.description"
                                readonly
                                label="Description" />
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
          <v-icon
            color="orange"
            title="Edit"
            class="mr-2"
            @click="editItem(item)">mdi-pencil
          </v-icon>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
import Form from 'vform'
import { ValidationObserver } from 'vee-validate'
import { mask } from 'vue-the-mask'
import VTextFieldWithValidation from '~/components/inputs/VTextFieldWithValidation'

export default {
  directives: {
    mask,
  },

  components: {
    ValidationObserver,
    VTextFieldWithValidation
  },

  data: () => ({
    dialog: false,
    loading: true,
    mask: '##:##:##',
    search: '',
    method: 'store',
    headers: [
      { text: 'Description', value: 'description' },
      { text: 'Value', value: 'value' },
      { text: 'Actions', value: 'action', sortable: false, align: 'center' },
    ],
    items: [],
    form: new Form({
      id: '',
      parameter: '',
      value: '',
      description: ''
    }),
  }),

  computed: {
    formTitle() {
      return this.method === 'store' ? this.$t('create') : this.$t('edit')
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
  },

  mounted() {
    this.getData();
  },

  methods: {
    async getData() {
      this.loading = true;
      try {
        const response  = await this.form.get('/api/configuration');
        this.items = response.data;
        this.loading = false;
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
        else {
          this.update();
        }
      }
    },
    async store() {
      try {
        const response = await this.form.post('/api/configuration');
        this.close();
        this.$toast.fire({
          type: 'success',
          title: 'Created'
        });
      } catch(error) {
        console.error(error);
      }
      this.getData();
    },
    async update() {
      try {
        const response = await this.form.patch('/api/configuration/'+this.form.id);
        this.close();
        this.$toast.fire({
          type: 'success',
          title: 'Updated'
        });
      } catch(error) {
        console.error(error);
      }
      this.getData();
    },
    editItem(item) {
      this.dialog = true;
      this.method = 'update';
      this.form.id = item.id;
      this.form.parameter = item.parameter;
      this.form.value = item.value;
      this.form.description = item.description;
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.clear();
        this.method = 'store';
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
