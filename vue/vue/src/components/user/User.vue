<template>
    <div class="User">
        <div class="header">
            <static-header :title="Gebruiker"></static-header>

            <div class="dynamic">


            </div>
        </div>
        <div class="content">

        </div>
    </div>
</template>

<script>
    import StaticHeader from "../partials/StaticHeader.vue"

    export default {
        name: 'User',
        components: {
            'static-header': StaticHeader,
        },
        data() {
            return {
                pageTitle: 'User'
            }
        }
    }
</script>


<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
