@extends('admin.index')
@section('title')
Payments
@endsection
@section('sub_title')
   {{trans('admin.payments_edit')}} 
@endsection
@section('back')
  <li><a href="{{aurl('payments')}}" class="btn btn-info">{{trans('admin.back')}}</a></li>
@endsection
@section('content')
<div class="box">
  <div class="box-header">
    
  </div>
   <!-- /.box-header -->
   <div class="box-body">
    {!! Form::open(['url'=>aurl('payments/'.$payment->id),'method'=>'put' ]) !!}
     <div class="form-group">
        {!! Form::label('amount',trans('admin.amount')) !!}
        {!! Form::text('amount',$payment->amount,['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
      {!! Form::label('restaurant_id',trans('admin.restaurant_id')) !!}
      {!! Form::select('restaurant_id',App\Models\Restaurant::pluck('name','id'),$payment->restaurant_id,['class'=>'form-control']) !!}
    </div>
     {!! Form::submit(trans('admin.save'),['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->



@endsection