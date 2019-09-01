<template>
  <div class="dashboard-layout">
    <div class="container-fluid">
      <navbar-dashboard />
      <div class="row">
        <sidebar-dashboard />
        <child />
      </div>
    </div>
  </div>
</template>

<script>
import NavbarDashboard from '~/components/NavbarDashboard'
import SidebarDashboard from '~/components/SidebarDashboard'

export default {
  name: 'DashboardLayout',
  components: {
    NavbarDashboard,
    SidebarDashboard
  }
}
</script>
