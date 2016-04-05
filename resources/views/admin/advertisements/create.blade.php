@extends('layout.admin')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">Create Advertisement</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <createadvertisement></createadvertisement>

                <template id="create-advertisement">
                    <div class="panel">
                        <div class="panel-body">
                            <label for="company_id">Company</label>
                            <select class="form-control selectPicker" v-model="company_id">
                                <option v-for="option in options" v-bind:value="option.id">
                                    @{{ option.name }}
                                </option>
                            </select>
                            <br>
                            <label for="start">Start</label>
                            <input type="text" v-model="start" class="form-control">
                            <br>
                            <label for="end">End</label>
                            <input type="text" v-model="end" class="form-control">
                            <br>
                            <label for="website">Website</label>
                            <input type="text" v-model="website" class="form-control">
                            <br>
                            <label for="amount">Amount</label>
                            <input type="text" v-model="amount" class="form-control">
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
                </template>
            </div>
        </div>
    </div>
@stop
