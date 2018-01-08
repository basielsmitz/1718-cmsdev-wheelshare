<template>
<div class="Home">
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
export default {
  name: 'Home',
  data() {
    return {
      msg: 'Home'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
