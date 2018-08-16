<template>
    <div class="login">
      <h1>Wheelshare</h1>
      <h3>Registreer</h3>
      <div class="logoContainer">
        <img :src="logo" alt="logo">
      </div>
        <div class="inputGroup">
            <label>name</label>
            <input type="text" name="name" id="name" v-model="name"><br>
            <label>mail</label>
            <input type="text" name="name" id="mail" v-model="mail"><br>
            <label>password</label>
            <input type="password" name="pass" id="pass" v-model="pass">
            <br><button type="button" @click="login">registreer</button>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import VueAxios from 'vue-axios'
    import logo from "@/assets/logo01.png"


    Vue.use(VueAxios, axios)
    export default {
        name: 'Login',
        data() {
            return {
                msg: 'Login',
                name: '',
                mail: '',
                pass: '',
                logo: logo,
            }
        },
        methods: {
            login: function () {
                self = this

                let data = {
                    "name": { "value": self.name },
                    "mail": { "value": self.mail },
                    "pass": { "value": self.pass }
                };
                let config = {
                    headers: {
                        'Content-Type': 'application/hal+json',
                        'X-CSRF-Token': 'RBCmBei2dkCsXeXTQbvFMVsN5XSHY1NFUM__C-QkjoA',

                    },
                }
                axios.post('http://drupal.dd:8083/user/register?_format=hal_json', data, config)
                    .then(({data: response})=> {
                    console.log(response)
                })
                    .catch(error => {console.error(error.message)});
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
