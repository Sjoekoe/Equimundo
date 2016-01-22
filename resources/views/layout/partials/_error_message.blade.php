@if ($errors->has($field))
    <small class="help-block text-danger text-left"><i class="fa fa-exclamation-circle"></i> {{ $errors->first($field) }}</small>
@endif
