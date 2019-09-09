<span class="label
{{ $is_active == 'active'?'label-info':'' }}
{{ $is_active == 'inactive'?'label-danger':'' }}
">

{{ trans('admin.'.$is_active) }}
</span>