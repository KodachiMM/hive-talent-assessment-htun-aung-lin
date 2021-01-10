@extends('admin.layouts.app')

@section('title', 'Services')
@section('services', 'active')

@section('content')
<services inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Services</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="button" class="btn btn-sm btn-primary" @click="showAddModal">Add New Service</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Service Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(service, index) in services" :key="service.id">
                        <td>@{{ pagination.from + index }}</td>
                        <td>@{{ service.name }}</td>
                        <td>@{{ service.price }}</td>
                        <td>
                            <a href="javascript:void(0);" @click="showEditModal(service)" title="Edit"><i class="feather icon-edit text-primary"></i></a>
                            |
                            <a href="javascript:void(0);" @click="showDeleteModal(service.id, service.name)" title="Delete"><i class="feather icon-trash-2 text-danger"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <vue-pagination :length.number="pagination.last_page" v-model="pagination.current_page" @input="getServices"></vue-pagination>
            </div>
        </div>

        <div class="modal fade" id="service-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@{{ is_edit == false ? 'Add Service' : 'Edit Service' }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form role="form" @submit.prevent="validateData" autocomplete="off">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Service Name <span class="text-danger">*</span></label>
                                <input type="text" :class="errors.has('name') ? 'form-control is-invalid' : 'form-control'" name="name" ref="name" v-model="service.name" v-validate="'required'">

                                <div class="text-danger" v-if="errors.has('name')">@{{ errors.first('name') }}</div>
                            </div>

                            <div class="form-group">
                                <label>Price <span class="text-danger">*</span></label>
                                <input type="text" :class="errors.has('price') ? 'form-control is-invalid' : 'form-control'" name="price" ref="price" v-model="service.price" v-validate="'required|decimal'">

                                <div class="text-danger" v-if="errors.has('price')">@{{ errors.first('price') }}</div>
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
                        <h5 class="modal-title">Delete Service</h5>

                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete <strong>@{{ service.name }}</strong>?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" @click="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</services>
@endsection