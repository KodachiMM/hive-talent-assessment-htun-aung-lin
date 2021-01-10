import "./config";
import "./components";

import DatePicker from "vue-bootstrap-datetimepicker";
import VeeValidate from "vee-validate";
import Notifications from "vue-notification";

Vue.use(DatePicker);
Vue.use(VeeValidate);
Vue.use(Notifications);

Vue.component("vue-pagination", () => import("./core/VuePagination"));
Vue.component("multiselect", () => import("vue-multiselect"));

$.extend(true, $.fn.datetimepicker.defaults, {
    icons: {
        time: "far fa-clock",
        date: "far fa-calendar",
        up: "fas fa-arrow-up",
        down: "fas fa-arrow-down",
        previous: "fas fa-chevron-left",
        next: "fas fa-chevron-right",
        today: "fas fa-calendar-check",
        clear: "far fa-trash-alt",
        close: "far fa-times-circle"
    }
});

new Vue({
    el: "#app"
});
