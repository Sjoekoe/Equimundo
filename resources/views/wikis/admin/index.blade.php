@extends('layout.admin', ['pageTitle' => true, 'title' => 'Wiki topics'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <wikitopicstable></wikitopicstable>

            <template id="wiki-topics-table">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-inline text-right">
                            <a href="#add-topic" data-toggle="modal" class="btn btn-info btn-labeled fa fa-plus">
                                Add
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="topic in topics">
                                        <td>@{{ topic.id }}</td>
                                        <td>@{{ topic.title }}</td>
                                        <td>
                                            <a href="#add-topic" data-toggle="modal" @click="fillUpdatedValues($index, topic)">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" @click="removeTopic(topic)">
                                                <i class="fa fa-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="add-topic" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <h3 class="m-t-none m-b" v-if="createModus">Create a new topic</h3>
                                    <h3 class="m-t-none m-b" v-else>Update topic</h3>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" placeholder="Enter title" class="form-control" v-model="newTitle">
                                    </div>
                                    <div v-if="createModus">
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" v-if="creating" disabled>
                                            <i class="fa fa-spin fa-spinner"></i> Creating...
                                        </button>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" v-else @click="createTopic">
                                            <strong>Create</strong>
                                        </button>
                                    </div>
                                    <div v-else>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" v-if="creating" disabled>
                                            <i class="fa fa-spin fa-spinner"></i> Updating...
                                        </button>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" v-else @click="updateTopic">
                                            <strong>Update</strong>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
@stop
