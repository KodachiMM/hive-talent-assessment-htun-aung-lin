import Vue from "vue";
import Popper from "popper.js";
import jQuery from "jquery";
import "bootstrap";
import axios from "axios";

import * as Notification from "./core/VueNotification";
import * as Helper from "./core/Helper";

window.Vue = Vue;
window.Notification = Notification;
window.Helper = Helper;

window.Popper = Popper;
window.$ = window.jQuery = window.jquery = jQuery;
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}
