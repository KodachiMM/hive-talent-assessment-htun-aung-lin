@extends('admin.layouts.app')

@section('title', 'Bookings')
@section('bookings', 'active')

@section('style')
<style>
    .booking-search {
        position: absolute;
        right: 0;
        width: 400px;
    }

    .clearfix {
        clear: both;
    }

    .invalid .multiselect {
        border: 1px solid red;
        border-radius: 5px;
    }
</style>
@endsection

@section('content')
<bookings inline-template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Bookings</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="button" class="btn btn-sm btn-primary" @click="showAddModal">Add New Booking</button>
            </div>
        </div>

        <div class="float-end">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" v-model="search" v-on:keyup.enter="searchClick">

                <span class="input-group-append">
                    <button class="btn btn-primary active" type="button" @click="searchClick">
                        <span class="feather icon-search"></span>
                    </button>
                </span>
            </div>
        </div>

        <div class="table-responsive mt-5 clearfix">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Booking Date</th>
                        <th>Customer Name</th>
                        <th>Car Number</th>
                        <th>Duration</th>
                        <th>Additional Services</th>
                        <th>Booking Status</th>
                        <th>Total Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(booking, index) in bookings" :key="booking.id">
                        <td>@{{ pagination.from + index }}</td>
                        <td>@{{ formatDate(booking.booking_date) }}</td>
                        <td>@{{ booking.customer_name }}</td>
                        <td>@{{ booking.car_number }}</td>
                        <td>@{{ booking.duration }}</td>
                        <td>
                            <span v-for="(service, index) in booking.services" :key="'service' + service.id">
                                @{{ service.name }}<span v-if="booking.services.length - 1 !== index">, </span>
                            </span>
                        </td>
                        <td>
                            <a v-if="booking.booking_status === 'Confirmed'" href="javascript:void(0);" @click="showBookingCompleteModal(booking.id, booking.customer_name)" class="text-primary">
                                @{{ booking.booking_status }}
                            </a>
                            <a v-else class="text-success">
                                @{{ booking.booking_status }}
                            </a>
                        </td>
                        <td>@{{ booking.total_amount }}</td>
                        <td>
                            <a href="javascript:void(0);" @click="viewVerificationNumber(booking.verification_number)" title="View Verification Number"><i class="feather icon-eye text-info"></i></a>
                            |
                            <a href="javascript:void(0);" @click="showEditModal(booking)" title="Edit"><i class="feather icon-edit text-primary"></i></a>
                            <span v-if="booking.booking_status !== 'Complete'">|</span>
                            <a v-if="booking.booking_status !== 'Complete'" href="javascript:void(0);" @click="showDeleteModal(booking.id)" title="Delete"><i class="feather icon-trash-2 text-danger"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <vue-pagination :length.number="pagination.last_page" v-model="pagination.current_page" @input="filter"></vue-pagination>
            </div>
        </div>

        <div class="modal fade" id="booking-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@{{ is_edit == false ? 'Add Booking' : 'Edit Booking' }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form role="form" @submit.prevent="validateData" autocomplete="off">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Date <span class="text-danger">*</span></label>
                                <date-picker v-model="booking.booking_date" :config="options" placeholder="Select Booking Date"></date-picker>
                            </div>

                            <div class="form-group" :class="{ 'invalid': isCustomerInvalid }">
                                <label>Customer Name <span class="text-danger">*</span></label>

                                <multiselect
                                    placeholder="Search a customer"
                                    v-model="selectedCustomer"
                                    label="full_name"
                                    name="full_name"
                                    v-validate="'required'"
                                    data-vv-name="full_name"
                                    track-by="full_name"
                                    :value="selectedCustomer"
                                    :loading="customerLoading"
                                    :options="asyncCustomers"
                                    :searchable="true"
                                    :internal-search="false"
                                    @search-change="getCustomers"
                                    @select="selectCustomer">
                                </multiselect>

                                <div class="text-danger" v-if="errors.has('full_name')">@{{ errors.first('full_name') }}</div>
                            </div>

                            <div class="form-group">
                                <label>Car Number <span class="text-danger">*</span></label>
                                <input type="text" :class="errors.has('car_number') ? 'form-control is-invalid' : 'form-control'" name="car_number" ref="car_number" v-model="booking.car_number" v-validate="'required'">

                                <div class="text-danger" v-if="errors.has('car_number')">@{{ errors.first('car_number') }}</div>
                            </div>

                            <div class="form-group">
                                <label>Duration <span class="text-danger">*</span></label>
                                <input type="text" :class="errors.has('duration') ? 'form-control is-invalid' : 'form-control'" name="duration" ref="duration" v-model="booking.duration" v-validate="'required|integer|min_value:1|max_value:30'">

                                <div class="text-danger" v-if="errors.has('duration')">@{{ errors.first('duration') }}</div>
                            </div>

                            <div class="form-group">
                                <label>Note</label>
                                <input type="text" :class="errors.has('note') ? 'form-control is-invalid' : 'form-control'" name="note" ref="note" v-model="booking.note" v-validate="'required'">

                                <div class="text-danger" v-if="errors.has('note')">@{{ errors.first('note') }}</div>
                            </div>

                            <label>Select Additional Services</label>

                            <div class="form-check" v-for="service in services">
                                <input class="form-check-input" type="checkbox" :value="service.id" :id="service.name" v-model="booking.services">
                                <label class="form-check-label" :for="service.name">
                                    @{{ service.name }}
                                </label>
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
                        <h5 class="modal-title">Delete Booking</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" @click="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="verification-number-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Verification Number</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        Verification number is <strong>@{{ verificationNumber }}</strong>.
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="booking-complete-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Complete Booking</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to complete booking for <strong>@{{ booking.customer_name }}</strong>?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" @click="completeBooking">Complete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</bookings>
@endsection