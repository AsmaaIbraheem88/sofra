@extends('admin.index')
@section('title')
Districts
@endsection
@section('sub_title')
   {{trans('admin.district_edit')}} 
@endsection
@section('back')
  <li><a href="{{aurl('districts')}}" class="btn btn-info">{{trans('admin.back')}}</a></li>
@endsection
@section('content')
<div class="box">
  <div class="box-header">
  </div>
   <!-- /.box-header -->
   <div class="box-body">
    {!! Form::open(['url'=>aurl('districts/'.$district->id),'method'=>'put' ]) !!}
     <div class="form-group">
        {!! Form::label('name_ar',trans('admin.name_ar')) !!}
        {!! Form::text('name_ar',$district->name_ar,['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('name_en',trans('admin.name_en')) !!}
        {!! Form::text('name_en',$district->name_en,['class'=>'form-control']) !!}
     </div>
     
    <div class="form-group">
        {!! Form::label('city_id',trans('admin.city_id')) !!}
        {!! Form::select('city_id',App\Models\City::pluck('name_'.session('lang'),'id'),$district->city_id,['class'=>'form-control','placeholder'=>trans('admin.choose_city')]) !!}
     </div>
     {!! Form::submit(trans('admin.save'),['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->



@endsection