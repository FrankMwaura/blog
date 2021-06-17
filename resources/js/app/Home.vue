<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Home Component</div>

                    <div class="card-body">
                        I'm an home component.
                    </div>
                </div>
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
