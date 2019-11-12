<template>
  <v-row>
    <v-col cols="12">
      <v-data-table
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
              <v-col cols="9">
                <v-row align="center">
                  <v-col cols="4">
                    <v-select
                      :items="years"
                      v-model="year"
                      label="Year"
                      outlined
                      hide-details>
                    </v-select>
                  </v-col>
                  <v-col cols="4">
                    <v-select
                      :items="months"
                      v-model="month"
                      label="Month"
                      outlined
                      hide-details>
                    </v-select>
                  </v-col>
                  <v-col cols="4">
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
                </v-row>
              </v-col>
              <v-col cols="3">
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
            title="Detail"
            @click="detailPresence(item)">mdi-open-in-new
          </v-icon>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>

<script>
import axios from 'axios'

export default {
  data: () => ({
    years: window.config.listYears,
    year: new Date().getFullYear(),
    months: window.config.listMonths,
    month: new Date().getMonth()+1,
    grades: [],
    grade: 'All',
    loading: true,
    search: '',
    headers: [
      { text: 'Name', value: 'name' },
      { text: 'Week 1', value: 'week1' },
      { text: 'Week 2', value: 'week2' },
      { text: 'Week 3', value: 'week3' },
      { text: 'Week 4', value: 'week4' },
      { text: 'Week 5', value: 'week5' },
      { text: 'Actions', value: 'action', sortable: false, align: 'center' },
    ],
    items: [],
  }),

  mounted() {
    this.getDataGrade();
    this.getData();
  },

  watch: {
    grade(val) {
      this.getData()
    },
    month(val) {
      this.getData()
    },
    year(val) {
      this.getData()
    }
  },

  methods: {
    async getData() {
      this.loading = true;
      try {
        const response = await axios.get('/api/presence', {
          params: {
            grade: this.grade,
            month: this.month,
            year: this.year
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
        const response  = await axios.get('/api/grade');
        this.grades = response.data;
        this.grades = ['All'].concat(this.grades);
      } catch (error) {
        console.error(error);
      }
    },
    detailPresence(item) {
      this.$router.push({ name: 'presence.detail', params: { child_id: item.id } });
    },
  }
}
</script>
