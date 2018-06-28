import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter);

import List from './components/List.vue'
import Article from './components/Article.vue'

const router = new VueRouter({
    routes: [
        { path: '/list', component: List },
        { path: '/list/:id', component: Article },
        { path: '/', redirect: '/list' }
    ]
})

export default router