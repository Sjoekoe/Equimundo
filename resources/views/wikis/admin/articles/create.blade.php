@extends('layout.admin', ['pageTitle' => true, 'title' => 'Create article for ' . $topic->title()])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                {{ Form::open() }}
                    <div class="ibox-title">
                        <h5>{{ 'Create article for ' . $topic->title() }}</h5>
                    </div>
                    <div class="ibox-content no-padding">
                       <div class="form-group m-sm">
                           {{ Form::label('title', 'Title', ['class' => 'control-label']) }}
                           {{ Form::text('title', '', ['class' => 'form-control']) }}
                       </div>
                        <div class="form-group">
                            <textarea name="body" id="body"></textarea>
                        </div>
                    </div>
                    <div class="ibox-footer text-right">
                        {{ Form::submit('save', ['class' => 'btn btn-info']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script>
        $(document).ready(function(){
            $('#body').summernote();
        });
    </script>
@stop
