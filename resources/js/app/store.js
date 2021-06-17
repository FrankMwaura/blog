import Vuex from 'vuex'
import Vue from 'vue'
import Axios from 'axios'

Vue.use(Vuex)

export const store = new Vuex.Store({
    namespaced: true,
    state: {
        categories: [],
        blogs: [],
        blog: {},
        token: localStorage.getItem('auth') || '',
    },
    getters: {
        blogList(state){
            return state.blogs
        },
        singleBlog(state){
            return state.blog
        },
        deleteBlog(context, payload){
            Axios.delete('/api/blog/'+payload)
                .then(res=>{
                    context.commit('blogList', res.data.blogs)
                })
        },
        categoryList(state){
            return state.categories
        }
    },
    actions: {
        blogList(context, payload){
            Axios.get('/api/blog/?page='+payload)
                .then(res=>{
                    context.commit('blogList', res.data.blogs)
                })
        },
        getAllBlog(context, payload){
            Axios.get('/blog-list/?page='+payload)
                .then(res=>{
                    context.commit('blogList', res.data.blogs)
                })
        },
        deleteBlog(context, payload){
            Axios.delete('/api/blog/'+payload)
                .then(res=>{
                    context.commit('blogList', res.data.blogs)
                })
        },
        editBlog(context, payload){
            Axios.get(`/api/blog/${payload}/edit`)
                .then(res=>{
                    context.commit('singleBlog', res.data.blog)
                })
        },
        categoryList(context, payload){
            Axios.get('/api/category/?page='+payload)
                .then(res=>{
                    context.commit('categoryList', res.data.categories)
                })
        },
        deleteCategory(context, payload){
            Axios.delete('/api/category/'+payload)
                .then(res=>{
                    context.commit('categoryList', res.data.categories)
                })
        },
        categoryListAll(context){
            Axios.get('/api/all-category')
                .then(res=>{
                    context.commit('categoryList', res.data.categories)
                })
        },
    },
    mutations:{
        setToken(state,token){
            localStorage.setItem('auth',token)
            state.token = token
        },
        clearToken(state){
            localStorage.removeItem('auth')
            state.token = ''
        },
        categoryList(state, payload){
            return state.categories = payload
        },
        blogList(state, payload){
            return state.blogs = payload
        },
        singleBlog(state, payload){
            return state.blog = payload
        }
    }
})