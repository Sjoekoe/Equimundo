@extends('layout.admin', ['pageTitle' => true, 'title' => $topic->title()])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <articlestable></articlestable>

            <template id="articles-table">
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-inline text-right">
                            <a href="{{ route('admin.article.create', $topic->id()) }}" data-toggle="modal" class="btn btn-info btn-labeled fa fa-plus">
                                Add
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>views</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="article in articles">
                                    <td>@{{ article.id }}</td>
                                    <td>
                                        @{{ article.title }}
                                    </td>
                                    <td>
                                        @{{ article.views }}
                                    </td>
                                    <td>
                                        <a href="/admin/wiki/topics/@{{ article.topicRelation.data.id }}/articles/@{{ article.slug }}/edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" @click=removeArticle(article)>
                                            <i class="fa fa-remove"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
@stop
