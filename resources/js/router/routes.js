function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },
  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ]
  },
  { path: '/children',
    component: page('children/index.vue'),
    children: [
      { path: '', name: 'children.list', component: page('children/list.vue') }
    ]
  },
  { path: '/grade',
    component: page('grade/index.vue'),
    children: [
      { path: '', name: 'grade.list', component: page('grade/list.vue') }
    ]
  },
  { path: '/info-point',
    component: page('info_point/index.vue'),
    children: [
      { path: '', name: 'info_point.list', component: page('info_point/list.vue') }
    ]
  },
  { path: '/points',
    component: page('points/index.vue'),
    children: [
      { path: '', name: 'points.list', component: page('points/list.vue') },
      { path: 'detail-child/:child_id', name: 'points.detail', component: page('points/detail.vue') }
    ]
  },
  { path: '/slide-point',
    component: page('slide_point/index.vue'),
    children: [
      { path: '', name: 'slide_point.list', component: page('slide_point/list.vue') }
    ]
  },
  { path: '/presence',
    component: page('presence/index.vue'),
    children: [
      { path: '', name: 'presence.list', component: page('presence/list.vue') },
      { path: 'detail-child/:child_id', name: 'presence.detail', component: page('presence/detail.vue') }
    ]
  },
  { path: '/users',
    component: page('users/index.vue'),
    children: [
      { path: '', name: 'users.list', component: page('users/list.vue') }
    ]
  },
  { path: '/configuration',
    component: page('configuration/index.vue'),
    children: [
      { path: '', name: 'configuration.list', component: page('configuration/list.vue') }
    ]
  },

  { path: '*', component: page('errors/404.vue') }
]
