@extends('admin.index')
@section('title')
    Admins
@endsection

@section('sub_title')
   {{trans('admin.admin_create')}} 
@endsection

@section('back')
  <li><a href="{{aurl('admin')}}" class="btn btn-info">{{trans('admin.back')}}</a></li>
@endsection


@section('content')

@inject('model','App\Admin')
@inject('roles','App\Models\Role')

<div class="box">
  <div class="box-header">
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    {!! Form::open(['url'=>aurl('admin')]) !!}
     <div class="form-group">
        {!! Form::label('name',trans('admin.name')) !!}
        {!! Form::text('name',old('name'),['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('email',trans('admin.email')) !!}
        {!! Form::email('email',old('email'),['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('password',trans('admin.password')) !!}
        {!! Form::password('password',['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('password_confirmation',trans('admin.password_confirmation')) !!}
        {!! Form::password('password_confirmation',['class'=>'form-control']) !!}
     </div>
    

     <!-- <div class="form-group">
        <label for="roles_list">رتب المستخدمين</label>
         {!! Form::select('roles_list[]',App\Models\Role::pluck('name','id'),old('roles_list[]'),['class'=>'form-control','placeholder'=>trans('admin.choose_city')]) !!}
    </div> -->



     <div class="form-group"> 
      <label for="name" class="col-sm-4 control-label">{{trans('admin.roles')}}</label>
      <br>
     
      <input id="select_all" type="checkbox"> <label class="form-check-label" for="select_all">{{trans('admin.sellect_all')}} </label>
          <div class="row">
              @foreach($roles->all() as $role )

              <div class="col-sm-3">
                  <div class="form-check">
                    
                      <input class="form-check-input" type="checkbox" id="defaultCheck1" name="roles_list[]" value="{{$role->id}}"
                      
                      @if($model->hasRole($role->name))

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


@push('js')

<script>
   
    // Select all
    $("#select_all").click( function() {
        $("input[type='checkbox']").prop('checked',$(this).prop('checked'));
    });  
   
</script>

@endpush

@endsection




