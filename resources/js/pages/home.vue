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
          @click="getChartGender">{{ $t('refresh') }}
        </v-btn>
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
          @click="getChartGrade">{{ $t('refresh') }}
        </v-btn>
        <vue-apex-charts
          width="80%"
          type="donut"
          :options="chartGrade.options"
          :series="chartGrade.series">
        </vue-apex-charts>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <div class="d-block">
          <v-btn
            small
            outlined
            @click="getChartTotalPresence">{{ $t('refresh') }}
          </v-btn>
        </div>
        <div class="d-block">
          <v-row>
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
            <v-col cols="3">
              <v-select
                :items="years"
                v-model="year"
                label="Year"
                outlined
                hide-details>
              </v-select>
            </v-col>
          </v-row>
        </div>
        <vue-apex-charts
          height="360px"
          width="100%"
          type="bar"
          :options="chartTotalPresence.options"
          :series="chartTotalPresence.series">
        </vue-apex-charts>
      </v-col>
    </v-row>
  </v-container>
</template>

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
    grades: [],
    grade: 'All',
    years: window.config.listYears,
    year: new Date().getFullYear(),
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
    },
    chartTotalPresence: {
      series: [{
        name: 'W1',
        data: []
      }, {
        name: 'W2',
        data: []
      }, {
        name: 'W3',
        data: []
      }, {
        name: 'W4',
        data: []
      }, {
        name: 'W5',
        data: []
      }],
      options: {
        plotOptions: {
          bar: {
            horizontal: false,
            endingShape: 'rounded'
          }
        },
        title: {
          text: 'Total Presence',
          align: 'center',
          style: {
            fontSize: '13pt'
          }
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        },
        yaxis: {
          title: {
            text: 'Total'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val
            }
          }
        }
      }
    }
  }),

  mounted() {
    this.getDataGrade();
    this.getChartGender();
    this.getChartGrade();
    this.getChartTotalPresence();
  },

  watch: {
    grade(val) {
      this.getChartTotalPresence()
    },
    year(val) {
      this.getChartTotalPresence()
    }
  },

  methods: {
    async getDataGrade() {
      try {
        const response = await axios.get('/api/grade');
        this.grades = response.data;
        this.grades = ['All'].concat(this.grades);
      } catch (error) {
        console.error(error);
      }
    },
    async getChartGender() {
      try {
        const response = await axios.get('/api/chart/get-gender');
        this.chartGender.series = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    async getChartGrade() {
      try {
        const response = await axios.get('/api/chart/get-grade');
        this.chartGrade.options = {...this.chartGrade.options, ...{
          labels: response.data.labels
        }};
        this.chartGrade.series = response.data.series;
      } catch (error) {
        console.error(error);
      }
    },
    async getChartTotalPresence() {
      this.chartTotalPresence.series = [
        {data: []},
        {data: []},
        {data: []},
        {data: []},
        {data: []}
      ];
      try {
        const response = await axios.get('/api/chart/get-total-presence', {
          params: {
            grade: this.grade,
            year: this.year
          }
        });
        this.chartTotalPresence.series = [
          {data: response.data[1]},
          {data: response.data[2]},
          {data: response.data[3]},
          {data: response.data[4]},
          {data: response.data[5]}
        ];
      } catch (error) {
        console.error(error);
      }
    },
  }
}
</script>
