@extends('layout.app')

@section('content')
    <div id="page-content">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Create a Company
                    </h3>
                </div>
                <createcompany></createcompany>

                <template id="create-company">
                    <form>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="name" class="control-label">Name</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" for="name", v-model="name", class="form-control">
                                    <small class="help-block text-danger text-left" v-if="errors.name"><i class="fa fa-exclamation-circle"></i> @{{ errors.name }}</small>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="telephone" class="control-label">Telephone</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" for="telephone", v-model="telephone", class="form-control">
                                    <small class="help-block text-danger text-left" v-if="errors.telephone"><i class="fa fa-exclamation-circle"></i> @{{ errors.telephone }}</small>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="email" class="control-label">Email</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="email" for="email", v-model="email", class="form-control">
                                    <small class="help-block text-danger text-left" v-if="errors.email"><i class="fa fa-exclamation-circle"></i> @{{ errors.email }}</small>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="website" class="control-label">Website</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" for="website", v-model="website", class="form-control">
                                    <small class="help-block text-danger text-left" v-if="errors.website"><i class="fa fa-exclamation-circle"></i> @{{ errors.website }}</small>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="street" class="control-label">Street</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" for="street", v-model="street", class="form-control">
                                    <small class="help-block text-danger text-left" v-if="errors.street"><i class="fa fa-exclamation-circle"></i> @{{ errors.street }}</small>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="name" class="control-label">Zip</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" for="zip", v-model="zip", class="form-control">
                                    <small class="help-block text-danger text-left" v-if="errors.zip"><i class="fa fa-exclamation-circle"></i> @{{ errors.zip }}</small>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="city" class="control-label">City</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="city" for="city", v-model="city", class="form-control">
                                    <small class="help-block text-danger text-left" v-if="errors.city"><i class="fa fa-exclamation-circle"></i> @{{ errors.city }}</small>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="state" class="control-label">State</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" for="state", v-model="state", class="form-control">
                                    <small class="help-block text-danger text-left" v-if="errors.state"><i class="fa fa-exclamation-circle"></i> @{{ errors.state }}</small>
                                </div>
                            </div>
                            <br> <br>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="country" class="control-label">Country</label>
                                </div>
                                <div class="col-sm-10">
                                    <select name="country" id="country" v-model="country" class="form-control">
                                        @foreach(trans('countries') as $code => $country)
                                            <option value="{{ $code }}">{{ $country }}</option>
                                        @endforeach
                                    </select>
                                    <small class="help-block text-danger text-left" v-if="errors.country"><i class="fa fa-exclamation-circle"></i> @{{ errors.country }}</small>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="about" class="control-label">About</label>
                                </div>
                                <div class="col-sm-10">
                                    <textarea name="about" id="about" cols="30" rows="3" class="form-control" v-model="about"></textarea>
                                    <small class="help-block text-danger text-left" v-if="errors.about"><i class="fa fa-exclamation-circle"></i> @{{ errors.about }}</small>
                                </div>
                            </div>
                            <br><br>
                        </div>
                        <div class="panel-footer text-right">
                            <button class="btn btn-info" disabled v-if="submitting">
                                <i class="fa fa-spinner fa-spin"></i> @{{ submitState }}
                            </button>
                            <button class="btn btn-info" @click="submit" v-else>{{ trans('forms.buttons.save') }}</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
@stop
