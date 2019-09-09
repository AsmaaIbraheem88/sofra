
@extends('admin.index')
@section('title')
    Admins
@endsection
@section('sub_title')
   {{trans('admin.change_password')}} 
@endsection
@section('content')

<div class="box">
  <div class="box-header">
    <h3 class="box-title"></h3>
    
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    {!! Form::open(['url'=>aurl('change-password')]) !!}
     <div class="form-group">
        {!! Form::label('old-password',trans('admin.old-password')) !!}
        {!! Form::password('old-password',['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('password',trans('admin.password')) !!}
        {!! Form::password('password',['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('password_confirmation',trans('admin.password_confirmation')) !!}
        {!! Form::password('password_confirmation',['class'=>'form-control']) !!}
     </div>
    


    
     {!! Form::submit(trans('admin.save'),['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection