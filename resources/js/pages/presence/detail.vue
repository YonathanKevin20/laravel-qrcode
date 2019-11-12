<template>
  <v-row>
    <v-col cols="2">
      <v-card outlined>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Name: {{ child.name }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Grade: {{ child.grade.name }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-card>
    </v-col>
    <v-col cols="3">
      <v-select
        :items="years"
        v-model="year"
        label="Year"
        outlined
        hide-details>
      </v-select>
    </v-col>
    <v-col cols="2" offset="5" class="text-center">
      <a @click="$router.go(-1)">
        <v-btn small outlined>
          <v-icon small left>mdi-arrow-left</v-icon>{{ $t('back') }}
        </v-btn>
      </a>
    </v-col>
    <v-col cols="12">
      <v-simple-table :id="id">
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
              <td>{{ months[index] }}</td>
              <td>
                {{ item.week1.datetime }}
                <v-icon
                  color="orange"
                  title="Edit"
                  small
                  @click="openEditPresenceDialog(item.week1)">mdi-pencil
                </v-icon>
              </td>
              <td>
                {{ item.week2.datetime }}
                <v-icon
                  color="orange"
                  title="Edit"
                  small
                  @click="openEditPresenceDialog(item.week2)">mdi-pencil
                </v-icon>
              </td>
              <td>
                {{ item.week3.datetime }}
                <v-icon
                  color="orange"
                  title="Edit"
                  small
                  @click="openEditPresenceDialog(item.week3)">mdi-pencil
                </v-icon>
              </td>
              <td>
                {{ item.week4.datetime }}
                <v-icon
                  color="orange"
                  title="Edit"
                  small
                  @click="openEditPresenceDialog(item.week4)">mdi-pencil
                </v-icon>
              </td>
              <td>
                {{ item.week5.datetime }}
                <v-icon
                  color="orange"
                  title="Edit"
                  small
                  @click="openEditPresenceDialog(item.week5)">mdi-pencil
                </v-icon>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
      <form-edit-presence></form-edit-presence>
    </v-col>
  </v-row>
</template>

<script>
import axios from 'axios'

export default {
  data: () => ({
    id: 'table-detail-presence',
    years: window.config.listYears,
    year: new Date().getFullYear(),
    months: ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'Oktober', 'November', 'December'],
    items: [],
    child: {
      name: '',
      grade: {
        name: ''
      }
    }
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

  watch: {
    year(val) {
      this.getData()
    }
  },

  methods: {
    async getData() {
      try {
        const response = await axios.get('/api/presence/show-child/'+this.$route.params.child_id, {
          params: {
            year: this.year
          }
        });
        this.child = response.data.model;
        this.items = response.data.month;
      } catch (error) {
        console.error(error);
      }
    },
    openEditPresenceDialog(item) {
      this.$eventHub.$emit('form-edit-presence', item, true);
    }
  }
}
</script>
