<template>
    <div class="login">
      <h1>Wheelshare</h1>
        <div class="logoContainer">
          <img :src="logo" alt="logo">
        </div>
        <div class="inputGroup">
            <label>name</label>
            <input type="text" name="name" id="name" v-model="name"><br>
            <label>password</label>
            <input type="password" name="pass" id="pass" v-model="pass">
            <br><button type="button" @click="login">login</button>
            <!-- <button type="button" @click="postSomething">post</button> -->
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import VueAxios from 'vue-axios'
    import CookieMixin from '@/mixins/CookieMixin'
    import logo from "@/assets/logo01.png"

    Vue.use(VueAxios, axios)
    export default {
        name: 'Login',
        mixins: [CookieMixin],
        data() {
            return {
                msg: 'Login',
                logo: logo,
                name: '',
                pass: ''
            }
        },
        methods: {
            login: function () {
                self = this
                let data = {
                    "name": self.name,
                    "pass": self.pass
                };
                let config = {
                    headers: {
                        'Content-Type': 'application/hal+json',
                    },
                }
                axios.post('http://drupal.dd:8083/user/login?_format=json', data, config)
                    .then(({data: response}) => {
                        console.log(response)
                        self.setCookie('userData', JSON.stringify({
                            auth: btoa(self.name + ":" + self.pass),
                            user: response,
                        }), 1);
                        this.$router.push({ name: 'Overview' });
                    })
                    .catch(error => {
                        console.error(error.message)
                    });
            },
        },
        mounted() {
          if(document.cookie){
            console.log('cookie');
            this.$router.push({ name: 'Overview' });
          }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
