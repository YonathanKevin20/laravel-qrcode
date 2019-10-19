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
                          <v-row>
                            <v-col cols="6">
                              <VTextFieldWithValidation
                                rules="required"
                                v-model="form.place_of_birth"
                                label="Place of Birth" />
                            </v-col>
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
                                    v-model="form.date_of_birth"
                                    label="Date of Birth"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-on="on" />
                                </template>
                                <v-date-picker
                                  ref="picker"
                                  color="blue"
                                  v-model="form.date_of_birth"
                                  :max="new Date().toISOString().substr(0, 10)"
                                  min="1950-01-01"
                                  @change="saveDate">
                                </v-date-picker>
                              </v-menu>
                            </v-col>
                          </v-row>
                          <v-row>
                            <v-col cols="6">
                              <VRadioWithValidation
                                rules="required"
                                v-model="form.gender"
                                :label="genderOptions"
                                name="Gender" />
                            </v-col>
                            <v-col cols="6">
                              <VTextFieldWithValidation
                                rules="required|numeric"
                                v-model="form.grade"
                                label="Grade" />
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
            title="QR Code"
            class="mr-2"
            @click="openQrCodeDialog(item)">mdi-qrcode
          </v-icon>
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
          <qr-code
            :id='item.id'>
          </qr-code>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
import Form from 'vform'
import { ValidationObserver } from "vee-validate"
import VTextFieldWithValidation from '~/components/inputs/VTextFieldWithValidation'
import VRadioWithValidation from '~/components/inputs/VRadioWithValidation'

export default {
  components: {
    ValidationObserver,
    VTextFieldWithValidation,
    VRadioWithValidation,
  },

  data: () => ({
    genderOptions: [
      { label: 'Male', value: 'm' },
      { label: 'Female', value: 'f' },
    ],
    dialog: false,
    loading: true,
    search: '',
    method: 'store',
    headers: [
      { text: 'Name', value: 'name' },
      { text: 'Age', value: 'age'},
      { text: 'Gender', value: 'gender' },
      { text: 'Grade', value: 'grade' },
      { text: 'Actions', value: 'action', sortable: false, align: 'center' },
    ],
    items: [],
    menuDate: false,
    form: new Form({
      id: '',
      name: '',
      gender: '',
      place_of_birth: '',
      date_of_birth: '',
      grade: '',
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
    menuDate(val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    },
  },

  mounted() {
    this.getData();
  },

  methods: {
    async getData() {
      this.loading = true;
      try {
        const response  = await this.form.get('/api/child');
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
        else {
          this.update();
        }
      }
    },
    async store() {
      try {
        const response = await this.form.post('/api/child');
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
    async update() {
      try {
        const response = await this.form.patch('/api/child/'+this.form.id);
        this.getData();
        this.close();
        this.$toast.fire({
          type: 'success',
          title: 'Updated'
        });
        console.log(response);
      } catch(error) {
        console.error(error);
      }
    },
    editItem(item) {
      this.dialog = true;
      this.method = 'update';
      this.form.id = item.id;
      this.form.name = item.name;
      this.form.gender = item.gender;
      this.form.place_of_birth = item.place_of_birth;
      this.form.date_of_birth = item.date_of_birth;
      this.form.grade = item.grade;
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
        const response = await this.form.delete('/api/child/'+id);
        this.getData();
        this.$toast.fire({
          type: 'success',
          title: 'Deleted'
        });
        console.log(response);
      } catch(error) {
        console.error(error);
      }
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
    },
    saveDate(date) {
      this.$refs.menu.save(date);
    },
    openQrCodeDialog(item) {
      this.$eventHub.$emit('qr-code-'+item.id, item, true);
    },
  }
}
</script>
