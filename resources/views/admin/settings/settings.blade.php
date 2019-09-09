@extends('admin.index')
@section('title')
    Settings
@endsection
@section('sub_title')
   {{trans('admin.settings')}} 
@endsection
@section('content')
<div class="box">
  <div class="box-header">

  </div>
  <!-- /.box-header -->
  <div class="box-body">
    {!! Form::open(['url'=>aurl('settings'),'files'=>true]) !!}
    <div class="form-group">
      {!! Form::label('sitename_ar',trans('admin.sitename_ar')) !!}
      {!! Form::text('sitename_ar',setting()->sitename_ar,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('sitename_en',trans('admin.sitename_en')) !!}
      {!! Form::text('sitename_en',setting()->sitename_en,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('email',trans('admin.email')) !!}
      {!! Form::email('email',setting()->email,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('logo',trans('admin.logo')) !!}
      {!! Form::file('logo',['class'=>'form-control']) !!}
      @if(!empty($settings->logo))
       <img src="{{asset('storage/settings/'.setting()->logo)}}" style="width:50px;height: 50px;" />
      @endif
    </div>
    <div class="form-group">
      {!! Form::label('icon',trans('admin.icon')) !!}
      {!! Form::file('icon',['class'=>'form-control']) !!}

         @if(!empty($settings->icon))
       <!-- <img src="{{ Storage::url(setting()->icon) }}" style="width:50px;height: 50px;" /> -->
      @endif

    </div>
    <div class="form-group">
      {!! Form::label('description',trans('admin.description')) !!}
      {!! Form::textarea('description',setting()->description,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('keywords',trans('admin.keywords')) !!}
      {!! Form::textarea('keywords',setting()->keywords,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('main_lang',trans('admin.main_lang')) !!}
      {!! Form::select('main_lang',['ar'=>trans('admin.ar'),'en'=>trans('admin.en')],setting()->main_lang,['class'=>'form-control']) !!}
    </div>
     <div class="form-group">
      {!! Form::label('status',trans('admin.status')) !!}
      {!! Form::select('status',['open'=>trans('admin.open'),'close'=>trans('admin.close')],setting()->status,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('message_maintenance',trans('admin.message_maintenance')) !!}
      {!! Form::textarea('message_maintenance',setting()->message_maintenance,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('max_credit',trans('admin.max_credit')) !!}
      {!! Form::text('max_credit',setting()->max_credit,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('commission',trans('admin.commission')) !!}
      {!! Form::text('commission',setting()->commission,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('commission_msg1',trans('admin.commission_msg1')) !!}
      {!! Form::textarea('message_commission_msg1',setting()->commission_msg1,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('commission_msg2',trans('admin.commission_msg2')) !!}
      {!! Form::textarea('message_commission_msg2',setting()->commission_msg2,['class'=>'form-control']) !!}
    </div>
    {!! Form::submit(trans('admin.save'),['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection

