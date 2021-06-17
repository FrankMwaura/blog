<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard Component</div>
                    <div v-if="loading">
                        <div class="spin">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading....</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" v-else>
                        I'm an dashboard component.
                        <button class="btn btn-primary" @click="logout">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
    export default {
        name: 'Dashboard',
        data(){
            return{
                loading: true
            }
        },
        methods:{
            logout(){
                axios.post('/api/logout', { token : this.$store.state.token })
                    .then(res=>{
                        this.$store.commit('clearToken')
                        this.$router.push('/')
                    })
            }
        },
        mounted() {
            if (this.$store.state.token !== '') {
                axios.post('/api/checkToken', { token : this.$store.state.token })
                    .then(res=>{
                        if (!res.data.success) {
                            this.$store.commit('setToken', res.data.token)
                        }
                        this.loading = false
                    })
                    .catch(err=>{
                        this.loading = false
                        this.$router.push('/login')
                    })
            }else{
                this.loading = false
                this.$router.push('/login')
            }
            console.log('Component mounted.')
        }
    }
</script>
