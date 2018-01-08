<template>
    <div class="UserHistory">
        <div class="header">
            <static-header :title="pageTitle"></static-header>

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
        name: 'UserHistory',
        components: {
            'static-header': StaticHeader,
        },
        data() {
            return {
                pageTitle: 'UserHistory'
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
