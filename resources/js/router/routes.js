const routes = [
    {
        path: '/',
        component: () => import('../pages/Books.vue'),
        name: 'books'
    },
    {
        path: '/book/:id',
        component: () => import('../pages/book/_id.vue'),
        name: 'book'
    }
]

export default routes