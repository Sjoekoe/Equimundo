@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>{{ trans('copy.strong.whoops') }}</strong> {{ trans('copy.p.input_problems') }}<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
