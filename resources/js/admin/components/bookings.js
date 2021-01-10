import moment from "moment";

export default {
    data() {
        return {
            bookings: [],
            booking: {
                id: null,
                booking_date: moment().format("DD MMM YYYY"),
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
        isCustomerInvalid() {
            return this.errors && this.errors.has("full_name");
        }
    },
    methods: {
        getBookings() {
            axios
                .get("/admin/bookings/all?page=" + this.pagination.current_page)
                .then(({ data }) => {
                    this.pagination = data;
                    this.bookings = data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        searchClick() {
            this.pagination.current_page = 1;
            this.filter();
        },
        filter() {
            if (this.search == "") {
                this.getBookings();
            } else {
                axios
                    .get(
                        "/admin/bookings/search/" +
                            this.search +
                            "?page=" +
                            this.pagination.current_page
                    )
                    .then(({ data }) => {
                        this.pagination = data;
                        this.bookings = data.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        showAddModal() {
            this.clearData();
            this.is_edit = false;
            $("#booking-modal").modal("show");
        },
        showEditModal(booking) {
            this.is_edit = true;
            this.booking = { ...booking };

            this.selectedCustomer.id = booking.customer_id;
            this.selectedCustomer.full_name = booking.customer_name;
            this.asyncCustomers.push(this.selectedCustomer);

            let _services = [];

            this.booking.services.map(e => {
                _services.push(e.id);
            });

            this.booking.services = _services;

            $("#booking-modal").modal("show");
        },
        clearData() {
            this.is_edit = false;
            this.booking.id = null;
            this.booking.booking_date = moment().format("DD MMM YYYY");
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
        async getCustomers(query) {
            this.customerLoading = true;

            return await axios
                .post("/admin/customers/async-customers", { name: query })
                .then(({ data }) => {
                    this.asyncCustomers = data;
                    this.customerLoading = false;
                });
        },
        selectCustomer(value) {
            this.booking.customer_id = value.id;
            this.booking.customer_name = value.full_name;
        },
        getServices() {
            axios
                .get("/admin/services/get-services")
                .then(({ data }) => {
                    this.services = data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        validateData() {
            this.$validator
                .validateAll()
                .then(successsValidate => {
                    if (successsValidate) {
                        this.submit();
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        submit() {
            let _path = !this.is_edit ? "create" : "update";

            axios
                .post("/admin/bookings/" + _path, this.booking)
                .then(({ data }) => {
                    if (data.status == true) {
                        this.getBookings();
                        $("#booking-modal").modal("hide");
                        Notification.success(
                            "Success! Verification code is sent to customer's phone."
                        );
                    } else {
                        let error_messages = "";

                        for (let key in data.message) {
                            if (data.message.hasOwnProperty(key)) {
                                error_messages += data.message[key] + "<br/>";
                            }
                        }

                        Notification.error(error_messages);
                    }
                })
                .catch(error => {
                    Notification.error(
                        "Error occurred while creating/updating data."
                    );
                });
        },
        showDeleteModal(id) {
            this.clearData();
            this.booking.id = id;
            $("#delete-modal").modal("show");
        },
        confirmDelete() {
            axios
                .get("/admin/bookings/delete/" + this.booking.id)
                .then(({ data }) => {
                    if (data.success) {
                        this.getBookings();
                        $("#delete-modal").modal("hide");
                        Notification.success("Success");
                    } else {
                        Notification.error(data.message);
                    }
                })
                .catch(error => {
                    Notification.error("Error occurred while deleting data.");
                });
        },
        formatDate(date) {
            return Helper.formatDatePretty(date);
        },
        viewVerificationNumber(verification_number) {
            this.verificationNumber = verification_number;
            $("#verification-number-modal").modal("show");
        },
        showBookingCompleteModal(id, customer_name) {
            this.booking.id = id;
            this.booking.customer_name = customer_name;
            $("#booking-complete-modal").modal("show");
        },
        completeBooking() {
            axios
                .post("/admin/bookings/complete", { id: this.booking.id })
                .then(({ data }) => {
                    if (data.status === true) {
                        this.getBookings();
                        $("#booking-complete-modal").modal("hide");
                        Notification.success(
                            "Success! Car pick up notification is sent to customer's phone."
                        );
                    } else {
                        let error_messages = "";

                        for (let key in data.message) {
                            if (data.message.hasOwnProperty(key)) {
                                error_messages += data.message[key] + "<br/>";
                            }
                        }

                        Notification.error(error_messages);
                    }
                })
                .catch(error => {
                    Notification.error(
                        "Error occurred while completing booking."
                    );
                });
        }
    },
    mounted() {
        this.getBookings();
        this.getServices();
    }
};
