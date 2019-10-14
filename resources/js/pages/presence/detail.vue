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
        <v-btn small outlined color="default">
          <v-icon small left>mdi-arrow-left</v-icon>Back
        </v-btn>
      </a>
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
              <td>{{ months[index] }}</td>
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

export default {
  data: () => ({
    years: [2019, 2020],
    year: new Date().getFullYear(),
    months: ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'Oktober', 'November', 'December'],
    items: [],
    grade: '',
    name: '',
  }),

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
        this.grade = response.data.model.grade;
        this.name = response.data.model.name;
        this.items = response.data.month;
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
