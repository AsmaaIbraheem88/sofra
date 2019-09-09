@extends('admin.index')
@section('title')
Orders
@endsection
@section('sub_title')
   {{trans('admin.order_list')}} 
@endsection

@section('content')
<div class="box">
  <div class="box-header">
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-xs-12 table-responsive">
    
        
      
      {!! $dataTable->table(['class'=>'dataTable table table-striped   table-bordered']) !!}
     
       
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->



@push('js')
{!! $dataTable->scripts() !!}
@endpush

@endsection