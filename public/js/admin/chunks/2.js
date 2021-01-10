(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

/***/ "./resources/js/admin/components/bookings.js":
/*!***************************************************!*\
  !*** ./resources/js/admin/components/bookings.js ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_1__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }


/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      bookings: [],
      booking: {
        id: null,
        booking_date: moment__WEBPACK_IMPORTED_MODULE_1___default()().format("DD MMM YYYY"),
        customer_id: null,
        customer_name: null,
        car_number: null,
        services: [],
        duration: null,
        note: null
      },
      is_edit: false,
      search: "",
      asyncCustomers: [],
      customerLoading: false,
      selectedCustomer: {
        id: "",
        full_name: ""
      },
      pagination: {
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
        last_page: 1
      },
      options: {
        format: "DD MMM YYYY",
        useCurrent: true
      },
      services: [],
      verificationNumber: null
    };
  },
  computed: {
    isCustomerInvalid: function isCustomerInvalid() {
      return this.errors && this.errors.has("full_name");
    }
  },
  methods: {
    getBookings: function getBookings() {
      var _this = this;

      axios.get("/admin/bookings/all?page=" + this.pagination.current_page).then(function (_ref) {
        var data = _ref.data;
        _this.pagination = data;
        _this.bookings = data.data;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    searchClick: function searchClick() {
      this.pagination.current_page = 1;
      this.filter();
    },
    filter: function filter() {
      var _this2 = this;

      if (this.search == "") {
        this.getBookings();
      } else {
        axios.get("/admin/bookings/search/" + this.search + "?page=" + this.pagination.current_page).then(function (_ref2) {
          var data = _ref2.data;
          _this2.pagination = data;
          _this2.bookings = data.data;
        })["catch"](function (error) {
          console.log(error);
        });
      }
    },
    showAddModal: function showAddModal() {
      this.clearData();
      this.is_edit = false;
      $("#booking-modal").modal("show");
    },
    showEditModal: function showEditModal(booking) {
      this.is_edit = true;
      this.booking = _objectSpread({}, booking);
      this.selectedCustomer.id = booking.customer_id;
      this.selectedCustomer.full_name = booking.customer_name;
      this.asyncCustomers.push(this.selectedCustomer);
      var _services = [];
      this.booking.services.map(function (e) {
        _services.push(e.id);
      });
      this.booking.services = _services;
      $("#booking-modal").modal("show");
    },
    clearData: function clearData() {
      this.is_edit = false;
      this.booking.id = null;
      this.booking.booking_date = moment__WEBPACK_IMPORTED_MODULE_1___default()().format("DD MMM YYYY");
      this.booking.customer_id = null;
      this.booking.customer_name = null;
      this.booking.car_number = null;
      this.booking.services = [];
      this.booking.duration = null;
      this.booking.note = null;
      this.asyncCustomers = [];
      this.selectedCustomer = {
        id: "",
        full_name: ""
      };
      this.$validator.reset();
    },
    getCustomers: function getCustomers(query) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this3.customerLoading = true;
                _context.next = 3;
                return axios.post("/admin/customers/async-customers", {
                  name: query
                }).then(function (_ref3) {
                  var data = _ref3.data;
                  _this3.asyncCustomers = data;
                  _this3.customerLoading = false;
                });

              case 3:
                return _context.abrupt("return", _context.sent);

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    selectCustomer: function selectCustomer(value) {
      this.booking.customer_id = value.id;
      this.booking.customer_name = value.full_name;
    },
    getServices: function getServices() {
      var _this4 = this;

      axios.get("/admin/services/get-services").then(function (_ref4) {
        var data = _ref4.data;
        _this4.services = data;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    validateData: function validateData() {
      var _this5 = this;

      this.$validator.validateAll().then(function (successsValidate) {
        if (successsValidate) {
          _this5.submit();
        }
      })["catch"](function (error) {
        console.log(error);
      });
    },
    submit: function submit() {
      var _this6 = this;

      var _path = !this.is_edit ? "create" : "update";

      axios.post("/admin/bookings/" + _path, this.booking).then(function (_ref5) {
        var data = _ref5.data;

        if (data.status == true) {
          _this6.getBookings();

          $("#booking-modal").modal("hide");
          Notification.success("Success! Verification code is sent to customer's phone.");
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
    showDeleteModal: function showDeleteModal(id) {
      this.clearData();
      this.booking.id = id;
      $("#delete-modal").modal("show");
    },
    confirmDelete: function confirmDelete() {
      var _this7 = this;

      axios.get("/admin/bookings/delete/" + this.booking.id).then(function (_ref6) {
        var data = _ref6.data;

        if (data.success) {
          _this7.getBookings();

          $("#delete-modal").modal("hide");
          Notification.success("Success");
        } else {
          Notification.error(data.message);
        }
      })["catch"](function (error) {
        Notification.error("Error occurred while deleting data.");
      });
    },
    formatDate: function formatDate(date) {
      return Helper.formatDatePretty(date);
    },
    viewVerificationNumber: function viewVerificationNumber(verification_number) {
      this.verificationNumber = verification_number;
      $("#verification-number-modal").modal("show");
    },
    showBookingCompleteModal: function showBookingCompleteModal(id, customer_name) {
      this.booking.id = id;
      this.booking.customer_name = customer_name;
      $("#booking-complete-modal").modal("show");
    },
    completeBooking: function completeBooking() {
      var _this8 = this;

      axios.post("/admin/bookings/complete", {
        id: this.booking.id
      }).then(function (_ref7) {
        var data = _ref7.data;

        if (data.status === true) {
          _this8.getBookings();

          $("#booking-complete-modal").modal("hide");
          Notification.success("Success! Car pick up notification is sent to customer's phone.");
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
        Notification.error("Error occurred while completing booking.");
      });
    }
  },
  mounted: function mounted() {
    this.getBookings();
    this.getServices();
  }
});

/***/ })

}]);