<template>
    <main>
        <!-- Dashboard -->
        <div v-if="isLoggedIn && !isQuesitonForm && !isLandingPage" class="d-flex">
            <div class="left_container">
                <side-bar></side-bar>
            </div>
            <div class="right_container">
                <nav-bar></nav-bar>
                <router-view/>
            </div>
        </div>
        <!-- ./Dashboard -->

        <div v-if="isLoggedIn && !isQuesitonForm && isLandingPage">
            <router-view/>
        </div>

        <!-- Auth Pages -->
        <div v-if="!isLoggedIn || isQuesitonForm">
            <router-view/>
        </div>
        <!-- ./Auth Pages -->
    </main>
</template>

<script>

import NavBar from './partials/NavBar';
import SideBar from './partials/SideBar';

export default {
    name: 'App',
    components: {
        NavBar,
        SideBar
    },
    computed: {
        isLoggedIn : function() { return this.$store.getters.authToken ? true : false },
        isQuesitonForm : function() { return this.$route.name == 'Registration' },
        isLandingPage : function() { return this.$route.fullPath.includes('landing-page') }
    },
    methods: {
        async logout () {
            await this.$store.dispatch('logOut');

            window.location.pathname = '/login';
            //this.$router.push('/login');
        },
        async getUser () {
            this.user = await this.$store.dispatch('getUser');
        }
    }
}
</script>

<style scoped>
/*@import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');
html, body {
  font-family: 'Open Sans', sans-serif;
}

#app {
  font-family: 'Open Sans', sans-serif;
}*/
</style>