(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./resources/js/admin/core/VuePagination.js":
/*!**************************************************!*\
  !*** ./resources/js/admin/core/VuePagination.js ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  template: "\n\t\t<nav aria-label=\"Page Navigation\">\n\t\t\t<ul class=\"pagination justify-content-center\" v-show=\"length > 1\">\n\t\t\t\t<li class=\"page-item\">\n\t\t\t\t\t<a href=\"#\" v-bind:class=\"value === 1 ? 'page-link pagination-disable' : 'page-link'\" v-on:click.prevent=\"$emit('input', value - 1)\">\n\t\t\t\t\t\tPrevious\n\t\t\t\t\t</a>\n\t\t\t\t</li>\n\t\t\t\t\n\t\t\t\t<li v-for=\"n in items\" :class=\"n === value ? 'page-item active' : 'page-item'\"> \n\t\t\t\t\t<a href=\"#\" v-if=\"! isNaN(n)\" v-on:click.prevent=\"$emit('input', n)\" v-text=\"n\" class=\"page-link\"\"></a>\n\t\t\t\t\t\n\t\t\t\t\t<a v-if=\"isNaN(n)\" class=\"page-link pagination-disable disabled\">\n\t\t\t\t\t\t<span v-text=\"n\" class=\"pagination-disable disabled\"></span>\n\t\t\t\t\t</a>\n\t\t\t\t</li>\n\n\t\t\t\t<li class=\"page-item\">\n\t\t\t\t\t<a href=\"#\" v-bind:class=\"value === length ? 'page-link pagination-disable' : 'page-link'\" v-on:click.prevent=\"$emit('input', value + 1)\">\n\t\t\t\t\t\tNext\n\t\t\t\t\t</a>\n\t\t\t\t</li>\n\t\t\t</ul>\n\t\t</nav>\n\t",
  props: {
    length: {
      type: Number,
      "default": 0
    },
    value: {
      type: Number,
      "default": 0
    }
  },
  computed: {
    items: function items() {
      if (this.length <= 10) {
        return this.range(1, this.length);
      }

      var min = this.value - 3;
      min = min > 0 ? min : 1;
      var max = min + 11;
      max = max <= this.length ? max : this.length;

      if (max === this.length) {
        min = this.length - 11;
      }

      var range = this.range(min, max);

      if (this.value >= 4 && this.length > 6) {
        range.splice(0, 2, 1, "...");
      }

      if (this.value + 3 < this.length && this.length > 6) {
        range.splice(range.length - 2, 2, "...", this.length);
      }

      return range;
    }
  },
  methods: {
    init: function init() {
      var _this = this;

      this.selected = null; // Change this

      setTimeout(function () {
        return _this.selected = _this.value;
      }, 100);
    },
    range: function range(from, to) {
      var range = [];
      from = from > 0 ? from : 1;

      for (var i = from; i <= to; i++) {
        range.push(i);
      }

      return range;
    }
  },
  watch: {
    value: function value() {
      this.init();
    }
  }
});

/***/ })

}]);