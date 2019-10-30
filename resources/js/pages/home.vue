<template>
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <v-container fluid>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $t('dashboard') }}</h2>
      </div>
      <v-btn
        small
        outlined
        @click="getDataGender">{{ $t('refresh') }}</v-btn>
      <vue-apex-charts
        width="400"
        type="pie"
        :options="chartGender.options"
        :series="chartGender.series">
      </vue-apex-charts>
    </v-container>
  </main>
</template>

<style>
[role="main"] {
  padding-top: 58px; /* Space for fixed navbar */
}
</style>

<script>
import axios from 'axios'
import VueApexCharts from 'vue-apexcharts'

export default {
  components: {
    VueApexCharts,
  },

  layout: 'dashboard',
  middleware: 'auth',
  metaInfo () {
    return { title: this.$t('dashboard') }
  },

  data: () => ({
    chartGender: {
      series: [],
      options: {
        colors: ['#3999d6', '#e83e77'],
        labels: ['Male', 'Female'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: '100%',
            },
          }
        }]
      }
    }
  }),

  mounted() {
    this.getDataGender();
  },

  methods: {
    async getDataGender() {
      try {
        const response = await axios.get('/api/chart/get-gender');
        this.chartGender.series = response.data;
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    },
  }
}
</script>
