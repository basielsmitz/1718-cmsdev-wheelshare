<template>
    <!--<div v-if="backgroundImage" class="headerImageOverlay"></div>-->
    <div  class="static">
        <div v-on:click="menuActive = !menuActive" class="hamburger">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </div>
        <h1>{{ title }}</h1>
        <nav v-bind:class="{navActive: menuActive}">
            <div v-on:click="menuActive = !menuActive" class="close">
                <i class="fa fa-times" aria-hidden="true"></i>

            </div>
            <ul>
                <li>
                    <router-link :to="{ name: 'Overview'}">Overzicht</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'User'}">Gebruiker</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'Overview'}">Logout</router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        name: 'StaticHeader',
        props: ['title',],
        data() {
            return {
                menuActive: false,
            }
        }

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
