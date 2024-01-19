import { createRouter, createWebHashHistory } from 'vue-router'

import Home from '@/components/home-page'

let routes = [
{
    path: '/',
    component: Home,
    meta: {
        title: '首页',
    },
}]

const router = createRouter({
    history: createWebHashHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    window.document.title = to.meta.title
    next()
})

export default router