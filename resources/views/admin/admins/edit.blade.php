@extends('admin.index')
@section('title')
    Admins
@endsection

@section('sub_title')
   {{trans('admin.admin_edit')}} 
@endsection

@section('back')
  <li><a href="{{aurl('admin')}}" class="btn btn-info">{{trans('admin.back')}}</a></li>
@endsection

@section('content')
@inject('roles','App\Models\Role')

<div class="box">
  <div class="box-header">
  </div>
   <!-- /.box-header -->
   <div class="box-body">
    {!! Form::open(['url'=>aurl('admin/'.$admin->id),'method'=>'put' ]) !!}
     <div class="form-group">
        {!! Form::label('name',trans('admin.name')) !!}
        {!! Form::text('name',$admin->name,['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('email',trans('admin.email')) !!}
        {!! Form::email('email',$admin->email,['class'=>'form-control']) !!}
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
                      
                      @if($admin->hasRole($role->name))

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