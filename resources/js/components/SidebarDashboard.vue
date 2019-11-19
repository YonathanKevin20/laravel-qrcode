<template>
  <v-list>
    <v-list-item :to="{ name: 'home' }" link>
      <v-list-item-icon>
        <v-icon>mdi-home</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title>{{ $t('dashboard') }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item :to="{ name: 'points.list' }" link>
      <v-list-item-icon>
        <v-icon>mdi-counter</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title>{{ $t('points') }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item :to="{ name: 'presence.list' }" link>
      <v-list-item-icon>
        <v-icon>mdi-calendar-clock</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title>{{ $t('presence') }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item :to="{ name: 'slide_point.list' }" target="_blank" link>
      <v-list-item-icon>
        <v-icon>mdi-play-box-outline</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title>{{ $t('slide_point') }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-divider></v-divider>
    <v-list-item :to="{ name: 'children.list' }" link>
      <v-list-item-icon>
        <v-icon>mdi-account-group</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title>{{ $t('children') }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item :to="{ name: 'grade.list' }" link>
      <v-list-item-icon>
        <v-icon>mdi-database</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title>{{ $t('grade') }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item :to="{ name: 'info_point.list' }" link>
      <v-list-item-icon>
        <v-icon>mdi-database</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title>{{ $t('info_point') }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item :to="{ name: 'users.list' }" link>
      <v-list-item-icon>
        <v-icon>mdi-account</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title>{{ $t('users') }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item :to="{ name: 'configuration.list' }" link>
      <v-list-item-icon>
        <v-icon>mdi-settings</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title>{{ $t('configuration') }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
}
</script>
