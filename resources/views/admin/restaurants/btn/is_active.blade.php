<span  style="color:
{{ $is_active == 'active'?'blue':'' }}
{{ $is_active == 'inactive'?'red':'' }}
">

{{ trans('admin.'.$is_active) }}
</span>