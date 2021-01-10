export default {
    data() {
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
        getServices() {
            axios
                .get("/admin/services/all?page=" + this.pagination.current_page)
                .then(({ data }) => {
                    this.pagination = data;
                    this.services = data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        showAddModal() {
            this.clearData();
            this.is_edit = false;
            $("#service-modal").modal("show");
        },
        showEditModal(service) {
            this.is_edit = true;
            this.service = { ...service };
            $("#service-modal").modal("show");
        },
        clearData() {
            this.is_edit = false;
            this.service.id = null;
            this.service.name = null;
            this.service.price = null;
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
                .post("/admin/services/" + _path, this.service)
                .then(({ data }) => {
                    if (data.status == true) {
                        this.getServices();
                        $("#service-modal").modal("hide");
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
        showDeleteModal(id, name) {
            this.clearData();
            this.service.id = id;
            this.service.name = name;
            $("#delete-modal").modal("show");
        },
        confirmDelete() {
            axios
                .get("/admin/services/delete/" + this.service.id)
                .then(({ data }) => {
                    if (data.success) {
                        this.getServices();
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
        this.getServices();
    }
};
