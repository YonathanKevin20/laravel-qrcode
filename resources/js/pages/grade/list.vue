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
                  <template v-slot:activator="{ on }">
                    <v-btn
                      class="white--text"
                      color="blue"
                      v-on="on">{{ $t('create') }}
                    </v-btn>
                  </template>
                  <ValidationObserver ref="obs">
                    <v-card>
                      <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                      </v-card-title>
                      <v-card-text>
                        <v-container>
                          <v-row>
                            <v-col cols="12">
                              <VTextFieldWithValidation
                                rules="required"
                                v-model="form.name"
                                label="Name" />
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
          <v-icon
            color="red"
            title="Delete"
            @click="checkDelete(item.id)">mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
import Form from 'vform'
import { ValidationObserver } from 'vee-validate'
import VTextFieldWithValidation from '~/components/inputs/VTextFieldWithValidation'

export default {
  components: {
    ValidationObserver,
    VTextFieldWithValidation
  },

  data: () => ({
    dialog: false,
    loading: true,
    search: '',
    method: 'store',
    headers: [
      { text: 'Name', value: 'name' },
      { text: 'Actions', value: 'action', sortable: false, align: 'center' },
    ],
    items: [],
    form: new Form({
      id: '',
      name: '',
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
        const response  = await this.form.get('/api/grade');
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
        const response = await this.form.post('/api/grade');
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
        const response = await this.form.patch('/api/grade/'+this.form.id);
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
      this.form.name = item.name;
    },
    checkDelete(id) {
      this.$swal.fire(this.confirmDelete).then((result) => {
        if(result.value) {
          this.delete(id);
        }
      })
    },
    async delete(id) {
      try {
        const response = await this.form.delete('/api/grade/'+id);
        this.$toast.fire({
          type: 'success',
          title: 'Deleted'
        });
      } catch(error) {
        console.error(error);
      }
      this.getData();
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
