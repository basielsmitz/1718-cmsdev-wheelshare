import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';

Vue.use(VueAxios, axios);

export default {
  methods: {
    login(uname, upass) {
      console.log('using mixins login function');
      self = this

      let data = {
        "name": uname,
        "pass": upass
      };
      let config = {
        headers: {
          'Content-Type': 'application/hal+json',
        },
      }
      axios.post('http://drupal.dd:8083/user/login?_format=json', data, config)
        .then((response) => {
          console.log(response)
          self.setCookie('userData', JSON.stringify({
            auth: btoa(uname + ":" + upass),
            user: response,
          }), 1);
        })
        .catch(error => {
          console.error(error.message)
        });
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
    },
    setCookie(cname, cvalue, exdays) {
      let d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      let expires = "expires=" + d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

    },
  },
  mounted() {
    console.log('mixins mounted');
  }
}
