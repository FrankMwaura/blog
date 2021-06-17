<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        
                        <div v-if="loading">
                            <div class="spin">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading....</span>
                                </div>
                            </div>
                        </div>
                        <form action="" class="form" v-else>
                            <div class="form-group">
                                <input class="form-control" v-model="credentials.email" placeholder="Email" type="email">
                            </div>
                            <div class="form-group">
                                <input class="form-control" v-model="credentials.password" placeholder="Password" type="password">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" @click.prevent="login">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
    export default {
        name: 'Login',
        data(){
            return{
                credentials : {
                    email: '',
                    password: ''
                },
                loading : true
            }
        },
        methods: {
            login(){
                axios.post('/api/login', this.credentials)
                    .then(res=>{
                        if (res.data.success) {
                            // update store
                            // console.log(res.data)
                            this.$store.commit('setToken', res.data.token)
                            this.$router.push('/dashboard')
                        }
                    })
                    .catch(err=>{
                        console.log('Error!')
                    })
            }
        },
        mounted() {
            if (this.$store.state.token !== '') {
                axios.post('/api/checkToken', { token : this.$store.state.token })
                    .then(res=>{
                        this.loading = false
                        if (res.data.success) {
                            this.$router.push('/dashboard')
                        }else{
                            this.$store.commit('setToken', res.data.token)
                        }
                    })
                    .catch(err=>{
                        this.loading = false
                        this.$store.commit('clearToken')
                    })
            }else{
                this.loading = false
            }
        }
    }
</script>
