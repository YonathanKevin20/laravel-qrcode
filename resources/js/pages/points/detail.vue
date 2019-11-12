<template>
  <v-row>
    <v-col cols="3">
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
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Total Point(s): {{ total }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-card>
    </v-col>
    <v-col cols="2" offset="7" class="text-center">
      <a @click="$router.go(-1)">
        <v-btn small outlined>
          <v-icon small left>mdi-arrow-left</v-icon>{{ $t('back') }}
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
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="items.length == 0">
              <td class="text-center" colspan="4">No Points</td>
            </tr>
            <tr v-else v-for="(item, index) in items" :key="index">
              <td>{{ item.qty }}</td>
              <td>{{ item.info_point.name }}</td>
              <td>{{ item.time }}</td>
              <td class="text-center">
                <v-icon
                  color="red"
                  title="Delete"
                  @click="checkDelete(item.id)">mdi-delete
                </v-icon>
              </td>
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
    child: {
      name: '',
      grade: {
        name: ''
      }
    }
  }),

  mounted() {
    this.getData();
  },

  computed: {
    total: function() {
      return this.items.reduce(function(total, item) {
        return total + item.qty; 
      }, 0);
    }
  },

  methods: {
    async getData() {
      try {
        const response = await axios.get('/api/point/show-child/'+this.$route.params.child_id);
        this.child = response.data.child;
        this.items = response.data.model;
      } catch (error) {
        console.error(error);
      }
    },
    checkDelete(id) {
      this.$swal.fire(this.confirmDelete).then((result) => {
        if(result.value) {
          this.delete(id);
        }
      })
    },
    async delete(id) {
      try {
        const response = await axios.delete('/api/point/'+id);
        this.$toast.fire({
          type: 'success',
          title: 'Deleted'
        });
      } catch(error) {
        console.error(error);
      }
      this.getData();
    },
  }
}
</script>
