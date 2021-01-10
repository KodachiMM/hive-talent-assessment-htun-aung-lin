export default {
    data() {
        return {
            admins: [],
            admin: {
                id: null,
                full_name: null,
                email: null,
                password: null
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
        getAdmins() {
            axios
                .get("/admin/admins/all?page=" + this.pagination.current_page)
                .then(({ data }) => {
                    this.pagination = data;
                    this.admins = data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        showAddModal() {
            this.clearData();
            this.is_edit = false;
            $("#admin-modal").modal("show");
        },
        showEditModal(admin) {
            this.$validator.detach("password");
            this.is_edit = true;
            this.admin = { ...admin };
            $("#admin-modal").modal("show");
        },
        clearData() {
            this.is_edit = false;
            this.admin.id = null;
            this.admin.full_name = null;
            this.admin.email = null;
            this.admin.password = null;
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
                .post("/admin/admins/" + _path, this.admin)
                .then(({ data }) => {
                    if (data.status == true) {
                        this.getAdmins();
                        $("#admin-modal").modal("hide");
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
            this.admin.id = id;
            this.admin.full_name = full_name;
            $("#delete-modal").modal("show");
        },
        confirmDelete() {
            axios
                .get("/admin/admins/delete/" + this.admin.id)
                .then(({ data }) => {
                    if (data.success) {
                        this.getAdmins();
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
        formatDateTime(date) {
            return Helper.formatDateTimePretty(date);
        }
    },
    mounted() {
        this.getAdmins();
    }
};
