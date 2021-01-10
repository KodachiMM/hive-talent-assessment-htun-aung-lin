(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[4],{

/***/ "./resources/js/admin/components/services.js":
/*!***************************************************!*\
  !*** ./resources/js/admin/components/services.js ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      services: [],
      service: {
        id: null,
        name: null,
        price: null
      },
      is_edit: false,
      pagination: {
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
        last_page: 1
      }
    };
  },
  methods: {
    getServices: function getServices() {
      var _this = this;

      axios.get("/admin/services/all?page=" + this.pagination.current_page).then(function (_ref) {
        var data = _ref.data;
        _this.pagination = data;
        _this.services = data.data;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    showAddModal: function showAddModal() {
      this.clearData();
      this.is_edit = false;
      $("#service-modal").modal("show");
    },
    showEditModal: function showEditModal(service) {
      this.is_edit = true;
      this.service = _objectSpread({}, service);
      $("#service-modal").modal("show");
    },
    clearData: function clearData() {
      this.is_edit = false;
      this.service.id = null;
      this.service.name = null;
      this.service.price = null;
      this.$validator.reset();
    },
    validateData: function validateData() {
      var _this2 = this;

      this.$validator.validateAll().then(function (successsValidate) {
        if (successsValidate) {
          _this2.submit();
        }
      })["catch"](function (error) {
        console.log(error);
      });
    },
    submit: function submit() {
      var _this3 = this;

      var _path = !this.is_edit ? "create" : "update";

      axios.post("/admin/services/" + _path, this.service).then(function (_ref2) {
        var data = _ref2.data;

        if (data.status == true) {
          _this3.getServices();

          $("#service-modal").modal("hide");
          Notification.success("Success");
        } else {
          var error_messages = "";

          for (var key in data.message) {
            if (data.message.hasOwnProperty(key)) {
              error_messages += data.message[key] + "<br/>";
            }
          }

          Notification.error(error_messages);
        }
      })["catch"](function (error) {
        Notification.error("Error occurred while creating/updating data.");
      });
    },
    showDeleteModal: function showDeleteModal(id, name) {
      this.clearData();
      this.service.id = id;
      this.service.name = name;
      $("#delete-modal").modal("show");
    },
    confirmDelete: function confirmDelete() {
      var _this4 = this;

      axios.get("/admin/services/delete/" + this.service.id).then(function (_ref3) {
        var data = _ref3.data;

        if (data.success) {
          _this4.getServices();

          $("#delete-modal").modal("hide");
          Notification.success("Success");
        } else {
          Notification.error(data.message);
        }
      })["catch"](function (error) {
        Notification.error("Error occurred while deleting data.");
      });
    }
  },
  mounted: function mounted() {
    this.getServices();
  }
});

/***/ })

}]);