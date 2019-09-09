<a href="{{ aurl('restaurants/'.$id.'/activated') }}" class="btn 

{{ $is_active == 'active'?'btn-danger':'' }}
{{ $is_active == 'inactive'?'btn-success':'' }}
"><i class="fa 

{{ $is_active == 'active'?'fa-close':'' }}
{{ $is_active == 'inactive'?'fa-check':'' }}

"></i></a>