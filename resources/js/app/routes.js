import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from './Home'
import Login from './Login'
import Dashboard from './Dashboard'
import Category from './Category'
import Blog from './Blog'
import AddUpdateBlog from './AddUpdateBlog'

Vue.use(VueRouter)

export const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/dashboard',
        component: Dashboard
    },
    {
        path: '/categories',
        component: Category
    },
    {
        path: '/blogs',
        component: Blog
    },
    {
        path: '/blogs',
        component: Blog,
        name: 'BlogList'
    },
    {
        path: '/add-blog',
        component: AddUpdateBlog,
        name: 'AddUpdateBlog'
    },
    {
        path: '/edit-blog/:blogId',
        component: AddUpdateBlog,
        name: 'editBlog'
    },
]