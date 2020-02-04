<template>
  <v-row>
    <v-col cols="12">
      <v-data-table
        :id="id"
        :headers="headers"
        :items="items"
        :search="search"
        :loading="loading"
        :items-per-page="20"
        :footer-props="{
          'items-per-page-options': [10, 20, 50, -1]
        }"
        loading-text="Loading... Please wait"
        class="elevation-1">
        <template v-slot:top>
          <v-container>
            <v-row align="center">
              <v-col cols="2">
                <v-btn
                  class="white--text"
                  color="purple"
                  @click.prevent="openImportDialog">{{ $t('import') }}</v-btn>
                <form-import-point></form-import-point>
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
                              <VTextFieldWithValidation
                                rules="required|numeric"
                                v-model="form.qty"
                                label="Point(s)" />
                            </v-col>
                            <v-col cols="6">
                              <VSelectWithValidation
                                rules="required"
                                v-model="form.info_point_id"
                                :items="infoPoints"
                                item-value="id"
                                item-text="name"
                                label="Info" />
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
              <v-col cols="3">
                <v-select
                  :items="grades"
                  item-value="id"
                  item-text="name"
                  v-model="grade"
                  label="Grade"
                  outlined
                  hide-details>
                </v-select>
              </v-col>
              <v-col offset="4" cols="3">
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
            title="Add"
            class="mr-2"
            @click="addPoint(item)">mdi-plus-circle-outline
          </v-icon>
          <v-icon
            title="Detail"
            @click="detailPoint(item)">mdi-open-in-new
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
import VSelectWithValidation from '~/components/inputs/VSelectWithValidation'

export default {
  components: {
    ValidationObserver,
    VTextFieldWithValidation,
    VSelectWithValidation,
  },

  data: () => ({
    id: 'table-points',
    grades: [],
    grade: 'All',
    infoPoints: [],
    dialog: false,
    loading: true,
    search: '',
    method: 'store',
    headers: [
      { text: 'Name', value: 'name' },
      { text: 'Grade', value: 'grade.name' },
      { text: 'Point(s)', value: 'qty' },
      { text: 'Actions', value: 'action', sortable: false, align: 'center' },
    ],
    items: [],
    form: new Form({
      child_id: '',
      name: '',
      qty: '',
      info_point_id: '',
    }),
  }),

  created() {
    let vm = this;
    this.$eventHub.$on('refresh-table', function(id) {
      if(id == vm.id) {
        vm.getData();
      }
    });
  },

  beforeDestroy() {
    this.$eventHub.$off('refresh-table');
  },

  mounted() {
    this.getDataGrade();
    this.getDataInfoPoint();
    this.getData();
  },

  computed: {
    formTitle() {
      return this.method === 'store' ? this.$t('add_points')+' to '+this.form.name : this.$t('edit')
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
    grade(val) {
      this.getData()
    }
  },

  methods: {
    async getData() {
      this.loading = true;
      try {
        const response = await this.form.get('/api/point', {
          params: {
            grade: this.grade
          }
        });
        this.items = response.data;
        this.loading = false;
      } catch (error) {
        console.error(error);
      }
    },
    async getDataGrade() {
      try {
        const response = await this.form.get('/api/grade');
        this.grades = response.data;
        this.grades = ['All'].concat(this.grades);
      } catch (error) {
        console.error(error);
      }
    },
    async getDataInfoPoint() {
      try {
        const response = await this.form.get('/api/info-point');
        this.infoPoints = response.data;
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
      this.form.reset();
      this.$nextTick(() => {
        this.$refs.obs.reset();
      });
    },
    openImportDialog() {
      this.$eventHub.$emit('form-import-point', true);
    },
    detailPoint(item) {
      this.$router.push({ name: 'points.detail', params: { child_id: item.child_id } });
    },
  }
}
</script>
