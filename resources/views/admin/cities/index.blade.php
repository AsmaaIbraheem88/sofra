@extends('admin.index')
@section('title')
    Cities
@endsection

@section('sub_title')
   {{trans('admin.city_list')}} 
@endsection

@section('content')
<div class="box">
  <div class="box-header">
  </div>
  <!-- /.box-header -->
  <div class="box-body">
  <div class="col-xs-12">
       <div class="table-responsive">
    {!! Form::open(['id'=>'form_data','url'=>aurl('cities/destroy/all'),'method'=>'delete']) !!}
    {!! $dataTable->table(['class'=>'dataTable table table-striped table-hover  table-bordered'],true) !!}
    {!! Form::close() !!}
</div>
</div>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->


<!-- Modal -->
<div id="mutlipleDelete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ trans('admin.delete') }}</h4>
      </div>
      <div class="modal-body">

        <div class="alert alert-danger">
        	<div class="empty_record hidden">
        	<h4>{{ trans('admin.please_check_some_records') }} </h4>
        	</div>
        	<div class="not_empty_record hidden">
        	<h4>{{ trans('admin.ask_delete_item') }} <span class="record_count"></span> ? </h4>
        	</div>
        </div>
      </div>
      <div class="modal-footer">
      	<div class="empty_record hidden">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.close') }}</button>
      	</div>
      	<div class="not_empty_record hidden">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.no') }}</button>
        <input type="submit"  value="{{ trans('admin.yes') }}"  class="btn btn-danger del_all" />
        </div>
      </div>
    </div>
  </div>
</div>


@push('js')
<script> delete_all()</script>
{!! $dataTable->scripts() !!}
@endpush

@endsection