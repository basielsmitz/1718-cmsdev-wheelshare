<template>
    <div class="Login">
        <h1>login</h1>
        <div class="inputGroup">
            <label>name</label>
            <input type="text" name="name" id="name" v-model="name"><br>
            <label>password</label>
            <input type="password" name="pass" id="pass" v-model="pass">
            <button type="button" @click="login">login</button>
            <button type="button" @click="postSomething">post</button>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import VueAxios from 'vue-axios'

    Vue.use(VueAxios, axios)
    export default {
        name: 'Login',
        data() {
            return {
                msg: 'Login',
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
                    })
                    .catch(error => {
                        console.error(error.message)
                    });
            },
            postSomething: function () {
                let self = this
                let cookie = (JSON.parse(self.getCookie('userData')));

                let data = {
                    "_links": {
                        "type": {
                            "href": "http://drupal.dd:8083/rest/type/node/article"
                        }
                    },
                    "title": {
                        "value": "Mijn test test  Artikel"
                    },
                    "type": {
                        "target_id": "article"
                    }
                };
                let config = {
                    headers: {
                        'Content-Type': 'application/hal+json',
                        'X-CSRF-Token': cookie.user.csrf_token,
                        'Authorization': 'Basic ' + cookie.auth,
                    },
                }
                axios.post('http://drupal.dd:8083/node', data, config)
                    .then(({data: response}) => {
                        console.log(response)
                    })
                    .catch(error => {
                        console.error(error.message)
                    });
            },
            setCookie(cname, cvalue, exdays) {
                let d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                let expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

            },
            getCookie(cname) {
                let name = cname + "=";
                let decodedCookie = decodeURIComponent(document.cookie);
                let ca = decodedCookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) === ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) === 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
