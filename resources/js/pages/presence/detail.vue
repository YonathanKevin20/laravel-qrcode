<template>
  <v-row>
    <v-col cols="2">
      <v-card outlined>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Name: {{ name }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Grade: {{ grade }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-card>
    </v-col>
    <v-col cols="2" offset="8" class="text-center">
      <v-btn small outlined color="default">
        <v-icon small left>mdi-arrow-left</v-icon> <a @click="$router.go(-1)">Back</a>
      </v-btn>
    </v-col>
    <v-col cols="12">
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th>Month</th>
              <th>Week 1</th>
              <th>Week 2</th>
              <th>Week 3</th>
              <th>Week 4</th>
              <th>Week 5</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in items" :key="index">
              <td>{{ index }}</td>
              <td>{{ item.week1 }}</td>
              <td>{{ item.week2 }}</td>
              <td>{{ item.week3 }}</td>
              <td>{{ item.week4 }}</td>
              <td>{{ item.week5 }}</td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-col>
  </v-row>
</template>

<script>
import axios from 'axios'
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

  data: () => ({
    id: 'table-points',
    months: window.config.listMonths,
    month: new Date().getMonth(),
    grades: ['All', 1, 2, 3],
    infoOptions: ['tambah', 'bonus'],
    dialog: false,
    loading: true,
    search: '',
    method: 'store',
    items: [],
    grade: '',
    name: '',
    form: new Form({
      child_id: '',
      name: '',
      qty: '',
      info: '',
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
    this.getData();
  },

  computed: {
    formTitle() {
      return this.method === 'store' ? this.$t('add_points')+' to '+this.form.name : this.$t('edit')
    },
  },

  methods: {
    async getData() {
      this.loading = true;
      try {
        const response = await axios.get('/api/presence/show-child/'+this.$route.params.child_id);
        this.grade = response.data.model.grade;
        this.name = response.data.model.name;
        this.items = response.data.month;
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
    detailPresence(item) {
      this.$router.push({ name: 'home' });
      // this.dialog = true;
      // this.method = 'store';
      // this.form.child_id = item.child_id;
      // this.form.name = item.name;
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
