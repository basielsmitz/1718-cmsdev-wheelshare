<template>
    <div class="UserDetail">
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
        name: 'UserDetail',
        components: {
            'static-header': StaticHeader,
        },
        data() {
            return {
                pageTitle: 'UserDetail'
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="sass">
    @import "../../assets/sass/specific/test2.scss"
</style>
