<template>
    <div>
        <div class="navbar">
            <div>
                <router-link to="/">Home</router-link>
            </div>
            <div>
                <router-link to="/login">Login</router-link>
            </div>
            <div>
                <router-link to="/dashboard">Dashboard</router-link>
            </div>
        </div>
        <div class="sidebar">
            <div>
                <router-link to="/categories">Categories</router-link>
            </div>
            <div>
                <router-link :to="{ name: 'BlogList' }">Blogs</router-link>
            </div>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: 'Home',
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>
    .navbar{
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: black;
        color: white;
    }
    .navbar div{
        padding: 5px 20px;
        margin: 5px;
    }
    .sidebar{
        display: flex-column;
        justify-content: center;
        align-items: center;
        background-color: black;
        color: white;
    }
</style>
