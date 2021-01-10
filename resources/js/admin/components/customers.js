export default {
    data() {
        return {
            customers: [],
            customer: {
                id: null,
                full_name: null,
                phone: null
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
        getCustomers() {
            axios
                .get(
                    "/admin/customers/all?page=" + this.pagination.current_page
                )
                .then(({ data }) => {
                    this.pagination = data;
                    this.customers = data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        showAddModal() {
            this.clearData();
            this.is_edit = false;
            $("#customer-modal").modal("show");
        },
        showEditModal(customer) {
            this.is_edit = true;
            this.customer = { ...customer };
            $("#customer-modal").modal("show");
        },
        clearData() {
            this.is_edit = false;
            this.customer.id = null;
            this.customer.full_name = null;
            this.customer.phone = null;
            this.$validator.reset();
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
                .post("/admin/customers/" + _path, this.customer)
                .then(({ data }) => {
                    if (data.status == true) {
                        this.getCustomers();
                        $("#customer-modal").modal("hide");
                        Notification.success("Success");
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
        showDeleteModal(id, full_name) {
            this.clearData();
            this.customer.id = id;
            this.customer.full_name = full_name;
            $("#delete-modal").modal("show");
        },
        confirmDelete() {
            axios
                .get("/admin/customers/delete/" + this.customer.id)
                .then(({ data }) => {
                    if (data.success) {
                        this.getCustomers();
                        $("#delete-modal").modal("hide");
                        Notification.success("Success");
                    } else {
                        Notification.error(data.message);
                    }
                })
                .catch(error => {
                    Notification.error("Error occurred while deleting data.");
                });
        }
    },
    mounted() {
        this.getCustomers();
    }
};
