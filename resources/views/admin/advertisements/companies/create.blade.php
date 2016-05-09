@extends('layout.admin', ['pageTitle' => true , 'title' => 'Create company'])

@section('content')
    <div class="row">
        <createadvertisingcompany></createadvertisingcompany>
        <template id="create-advertising-company">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Company Details
                        </h3>
                    </div>
                    <div class="panel-body">
                        <label for="name">Name</label>
                        <input type="text" v-model="name" class="form-control">
                        <br>
                        <label for="company_email">Email</label>
                        <input type="email" v-model="company_email" class="form-control">
                        <br>
                        <label for="company_telephone">Telephone</label>
                        <input type="text" v-model="company_telephone" class="form-control">
                        <br>
                        <label for="tax">Tax / VAT</label>
                        <input type="text" v-model="tax" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Company Contact
                        </h3>
                    </div>
                    <div class="panel-body">
                        <label for="first_name">First Name</label>
                        <input type="text" v-model="first_name" class="form-control">
                        <br>
                        <label for="last_name">Last Name</label>
                        <input type="text" v-model="last_name" class="form-control">
                        <br>
                        <label for="email">Email</label>
                        <input type="email" v-model="email" class="form-control">
                        <br>
                        <label for="telephone">Telephone</label>
                        <input type="text" v-model="telephone" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Address
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <label for="street">Street</label>
                            <input type="text" v-model="street" class="form-control">
                            <br>
                            <label for="city">City</label>
                            <input type="text" v-model="city" class="form-control">
                            <br>
                            <label for="country">Country</label>
                            <select name="country" id="country" v-model="country" class="form-control">
                                @foreach (trans('countries') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="zip">ZIP</label>
                            <input type="text" v-model="zip" class="form-control">
                            <br>
                            <label for="state">State</label>
                            <input type="text" v-model="state" class="form-control">
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <template v-if="submitting">
                            <button class="btn btn-info" disabled>
                                <i class="fa fa-spinner fa-spin"></i>
                                @{{ status }}
                            </button>
                        </template>
                        <template v-else>
                            <button class="btn btn-info" @click="Submit">Save</button>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>
@stop
