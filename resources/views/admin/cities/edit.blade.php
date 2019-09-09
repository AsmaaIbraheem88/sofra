@extends('admin.index')
@section('title')
    Cities
@endsection

@section('sub_title')
   {{trans('admin.city_edit')}} 
@endsection

@section('back')
  <li><a href="{{aurl('cities')}}" class="btn btn-info">{{trans('admin.back')}}</a></li>
@endsection
@section('content')
<div class="box">
  <div class="box-header">
  </div>
   <!-- /.box-header -->
   <div class="box-body">
    {!! Form::open(['url'=>aurl('cities/'.$city->id),'method'=>'put' ]) !!}
     <div class="form-group">
        {!! Form::label('name_ar',trans('admin.name_ar')) !!}
        {!! Form::text('name_ar',$city->name_ar,['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('name_en',trans('admin.name_en')) !!}
        {!! Form::text('name_en',$city->name_en,['class'=>'form-control']) !!}
     </div>
     {!! Form::submit(trans('admin.save'),['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->



@endsection