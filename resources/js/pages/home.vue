<template>
  <v-container fluid>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h2>{{ $t('dashboard') }}</h2>
    </div>
    <v-row>
      <v-col cols="6">
        <v-btn
          small
          outlined
          @click="getDataGender">{{ $t('refresh') }}</v-btn>
        <vue-apex-charts
          width="80%"
          type="pie"
          :options="chartGender.options"
          :series="chartGender.series">
        </vue-apex-charts>
      </v-col>
      <v-col cols="6">
        <v-btn
          small
          outlined
          @click="getDataGrade">{{ $t('refresh') }}</v-btn>
        <vue-apex-charts
          width="80%"
          type="donut"
          :options="chartGrade.options"
          :series="chartGrade.series">
        </vue-apex-charts>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from 'axios'
import VueApexCharts from 'vue-apexcharts'
import { mapGetters } from 'vuex'

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
          breakpoint: 720,
          options: {
            chart: {
              width: '100%',
            },
          }
        }]
      }
    },
    chartGrade: {
      series: [],
      options: {
        labels: [],
        responsive: [{
          breakpoint: 720,
          options: {
            chart: {
              width: '100%',
            },
          }
        }]
      }
    }
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  mounted() {
    if(this.authenticated) {
      this.getDataGender();
      this.getDataGrade();
    }
  },

  methods: {
    async getDataGender() {
      try {
        const response = await axios.get('/api/chart/get-gender');
        this.chartGender.series = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    async getDataGrade() {
      try {
        const response = await axios.get('/api/chart/get-grade');
        this.chartGrade.options = {
          labels: response.data.labels
        };
        this.chartGrade.series = response.data.series;
      } catch (error) {
        console.error(error);
      }
    },
  }
}
</script>
