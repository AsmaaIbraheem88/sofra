@extends('admin.index')
@section('title')
    Admin
@endsection
@section('content')
@inject('roles','App\Models\Role')
<div class="box">
  <div class="box-header">
    <h3 class="box-title">{{ $title }}</h3>
  </div>
   <!-- /.box-header -->
   <div class="box-body">
    {!! Form::open(['url'=>aurl('users/'.$user->id),'method'=>'put' ]) !!}
     <div class="form-group">
        {!! Form::label('name',trans('admin.name')) !!}
        {!! Form::text('name',$user->name,['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('email',trans('admin.email')) !!}
        {!! Form::email('email',$user->email,['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('password',trans('admin.password')) !!}
        {!! Form::password('password',['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('password_confirmation',trans('admin.password_confirmation')) !!}
        {!! Form::password('password_confirmation',['class'=>'form-control']) !!}
     </div>
    



     <div class="form-group"> 
      <label for="name" class="col-sm-4 control-label">Roles</label>
      <br>
      <input id="select_all" type="checkbox"> <label class="form-check-label" for="select_all">Select All</label>


          <div class="row">
              @foreach($roles->all() as $role )

              <div class="col-sm-3">
                  <div class="form-check">
                    
                      <input class="form-check-input" type="checkbox" id="defaultCheck1" name="roles_list[]" value="{{$role->id}}"
                      
                      @if($user->hasRole($role->name))

                          checked

                      @endif
                      >
                      <label class="form-check-label" for="defaultCheck1">
                      {{$role->display_name}}
                      </label>
                  
                  </div>
              </div>

              @endforeach
          </div>
    </div>


     {!! Form::submit(trans('admin.save'),['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->

@push('scripts')

<script>
   
    // Select all
    $("#select_all").click( function() {
        $("input[type='checkbox']").prop('checked',$(this).prop('checked'));
    });  
   
</script>

@endpush


@endsection