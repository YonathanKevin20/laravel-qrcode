<template>
  <v-list dense>
    <router-link :to="{ name: 'home' }" active-class="active">
      <v-list-item link>
        <v-list-item-action>
          <v-icon>mdi-home</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{ $t('dashboard') }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </router-link>
    <router-link :to="{ name: 'points.list' }" active-class="active">
      <v-list-item link>
        <v-list-item-action>
          <v-icon>mdi-counter</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{ $t('points') }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </router-link>
    <router-link :to="{ name: 'presence.list' }" active-class="active">
      <v-list-item link>
        <v-list-item-action>
          <v-icon>mdi-calendar-clock</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{ $t('presence') }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </router-link>
    <router-link :to="{ name: 'slide_point.list' }" active-class="active" target="_blank">
      <v-list-item link>
        <v-list-item-action>
          <v-icon>mdi-play-box-outline</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{ $t('slide_point') }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </router-link>
    <v-divider></v-divider>
    <router-link :to="{ name: 'children.list' }" active-class="active">
      <v-list-item link>
        <v-list-item-action>
          <v-icon>mdi-account-group</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{ $t('children') }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </router-link>
    <router-link :to="{ name: 'grade.list' }" active-class="active">
      <v-list-item link>
        <v-list-item-action>
          <v-icon>mdi-database</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{ $t('grade') }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </router-link>
    <router-link :to="{ name: 'info_point.list' }" active-class="active">
      <v-list-item link>
        <v-list-item-action>
          <v-icon>mdi-database</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{ $t('info_point') }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </router-link>
    <router-link :to="{ name: 'users.list' }" active-class="active">
      <v-list-item link>
        <v-list-item-action>
          <v-icon>mdi-account</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{ $t('users') }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </router-link>
    <router-link :to="{ name: 'configuration.list' }" active-class="active">
      <v-list-item link>
        <v-list-item-action>
          <v-icon>mdi-settings</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{ $t('configuration') }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </router-link>
  </v-list>
</template>

<script>
export default {
}
</script>
