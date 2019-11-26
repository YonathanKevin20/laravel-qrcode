<template>
  <v-carousel
    cycle
    style="height: 100%">
    <v-carousel-item v-for="(item, index) in items" :key="index">
      <v-sheet
        :color="colors[index]"
        height="100%"
        tile>
        <v-row
          style="height: 100vh"
          class="fill-height"
          align="center"
          justify="center">
          <v-card
            v-for="(child, i) in item" :key="i"
            color="white"
            class="pa-md-4 mx-lg-auto"
            width="250px"
            outlined>
            <v-list-item>
              <v-list-item-content class="black--text text-center title">
                <v-list-item-title>{{ child.name }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <v-list-item-content class="black--text text-center title">
                <v-list-item-title>{{ child.qty }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-card>
        </v-row>
      </v-sheet>
    </v-carousel-item>
  </v-carousel>
</template>

<style>
div.v-responsive.v-image.v-carousel__item {
  height: 100% !important;
}
</style>

<script>
import axios from 'axios'

export default {
  data: () => ({
    items: [],
    colors: [
      'primary',
      'orange',
      'yellow darken-2',
      'red',
      'cyan',
    ]
  }),

  mounted() {
    this.getData();
  },

  methods: {
    async getData() {
      try {
        const response  = await axios.get('/api/point/slide');
        this.items = response.data;
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
