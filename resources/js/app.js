require("./bootstrap");
window.Vue = require("vue");

import App from "./App.vue";
import VueRouter from "vue-router";
import VueAxios from "vue-axios";
import axios from "axios";
import { routes } from "./routes";
import { BootstrapVue } from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(BootstrapVue);

const router = new VueRouter({
  mode: "history",
  routes: routes
});

const app = new Vue({
  el: "#app",
  router: router,
  render: h => h(App)
});
