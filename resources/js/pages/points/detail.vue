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
              <th>Point(s)</th>
              <th>Info</th>
              <th>Time</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in items" :key="index">
              <td>{{ item.qty }}</td>
              <td>{{ item.info }}</td>
              <td>{{ item.time }}</td>
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
    items: [],
    grade: '',
    name: '',
  }),

  mounted() {
    this.getData();
  },

  methods: {
    async getData() {
      try {
        const response = await axios.get('/api/point/show-child/'+this.$route.params.child_id);
        this.grade = response.data[0].grade;
        this.name = response.data[0].name;
        this.items = response.data;
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
