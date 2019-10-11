<template>
  <nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
      <ul class="nav flex-column">
        <li class="nav-item">
          <router-link :to="{ name: 'home' }" class="nav-link" active-class="active">{{ $t('dashboard') }}</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'children.list' }" class="nav-link" active-class="active">{{ $t('children') }}</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'points.list' }" class="nav-link" active-class="active">{{ $t('points') }}</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'presence.list' }" class="nav-link" active-class="active">{{ $t('presence') }}</router-link>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            Configuration
          </a>
        </li>
      </ul>

      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Data Master</span>
        <a class="d-flex align-items-center text-muted" href="#">
        </a>
      </h6>
      <ul class="nav flex-column mb-2">
        <li class="nav-item">
          <router-link :to="{ name: 'users.list' }" class="nav-link" active-class="active">{{ $t('users') }}</router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
}
</script>

<style scoped>
.sidebar {
  /*position: fixed;*/
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 100; /* Behind the navbar */
  padding: 58px 0 0; /* Height of navbar */
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar-sticky {
  position: relative;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: .5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}

@supports ((position: -webkit-sticky) or (position: sticky)) {
  .sidebar-sticky {
    position: -webkit-sticky;
    position: sticky;
  }
}

.sidebar .nav-link {
  /*font-weight: 500;*/
  color: #333;
}

.sidebar .nav-link {
  margin-right: 4px;
  color: #999;
}

.sidebar .nav-link.active {
  color: #007bff;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active {
  color: inherit;
  font-weight: 500;
}

.sidebar-heading {
  font-size: .75rem;
  text-transform: uppercase;
}
</style>
