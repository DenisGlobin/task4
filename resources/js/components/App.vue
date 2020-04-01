<template>
    <div class="card">
        <div class="card-header">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link :to="{ name: 'api.documents.index', params: { page: 1, perPage: 10 } }" class="nav-link">Home</router-link>
                    </li>
                    <li v-if="$auth.check()" class="nav-item">
                        <router-link :to="{ name: 'api.documents.create' }" class="nav-link">Create document</router-link>
                    </li>
                    <li v-if="$auth.check()" class="nav-item">
                        <router-link :to="{ name: 'user' }" class="nav-link">Profile</router-link>
                    </li>
                    <li v-else class="nav-item">
                        <router-link :to="{ name: 'register' }" class="nav-link">Register</router-link>
                    </li>
                    <li v-if="$auth.check()" class="nav-item">
                        <a href="#" @click.prevent="$auth.logout()" class="nav-link">Logout</a>
                    </li>
                    <li v-else class="nav-item">
                        <router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
                    </li>
                </ul>
                </div>
            </nav>
        </div>
        <div class="card-body">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "App"
    }
</script>

<style scoped>

</style>