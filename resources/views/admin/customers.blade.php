@extends('admin.layouts.app')

@section('title', 'Customers')
@section('customers', 'active')

@section('content')
<customers inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Customers</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="button" class="btn btn-sm btn-primary" @click="showAddModal">Add New Customer</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(customer, index) in customers" :key="customer.id">
                        <td>@{{ pagination.from + index }}</td>
                        <td>@{{ customer.full_name }}</td>
                        <td>@{{ customer.phone }}</td>
                        <td>
                            <a href="javascript:void(0);" @click="showEditModal(customer)" title="Edit"><i class="feather icon-edit text-primary"></i></a>
                            |
                            <a href="javascript:void(0);" @click="showDeleteModal(customer.id, customer.full_name)" title="Delete"><i class="feather icon-trash-2 text-danger"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <vue-pagination :length.number="pagination.last_page" v-model="pagination.current_page" @input="getCustomers"></vue-pagination>
            </div>
        </div>

        <div class="modal fade" id="customer-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@{{ is_edit == false ? 'Add Customer' : 'Edit Customer' }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form role="form" @submit.prevent="validateData" autocomplete="off">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" :class="errors.has('full_name') ? 'form-control is-invalid' : 'form-control'" name="full_name" ref="full_name" v-model="customer.full_name" v-validate="'required'">

                                <div class="text-danger" v-if="errors.has('full_name')">@{{ errors.first('full_name') }}</div>
                            </div>

                            <div class="form-group">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="text" :class="errors.has('phone') ? 'form-control is-invalid' : 'form-control'" name="phone" ref="phone" v-model="customer.phone" v-validate="'required|decimal'">

                                <div class="text-danger" v-if="errors.has('phone')">@{{ errors.first('phone') }}</div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Customer</h5>

                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete <strong>@{{ customer.full_name }}</strong>?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" @click="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</customers>
@endsection