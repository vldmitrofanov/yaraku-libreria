const routes = [
  {
    path: '/',
    component: () => import('../pages/Books.vue'),
    name: 'books',
  },
  {
    path: '/book/:id',
    component: () => import('../pages/book/_id.vue'),
    name: 'book',
  },
  {
    path: '/e404',
    component: () => import('../pages/errors/e404.vue'),
    name: 'e404',
  },
  {
    path: '*',
    component: () => import('../pages/errors/e404.vue'),
  },
]

export default routes
