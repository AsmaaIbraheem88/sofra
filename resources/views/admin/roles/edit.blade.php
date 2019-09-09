@extends('admin.index')
@section('title')
    Roles
@endsection
@section('sub_title')
   {{trans('admin.role_edit')}} 
@endsection

@section('back')
  <li><a href="{{aurl('roles')}}" class="btn btn-info">{{trans('admin.back')}}</a></li>
@endsection
@section('content')
@inject('perm','App\Models\Permission')
<div class="box">
  <div class="box-header">
    <h3 class="box-title">{{ $title }}</h3>
  </div>
   <!-- /.box-header -->
   <div class="box-body">
    {!! Form::open(['url'=>aurl('roles/'.$role->id),'method'=>'put' ]) !!}
     <div class="form-group">
        {!! Form::label('name',trans('admin.name')) !!}
        {!! Form::text('name',$role->name,['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('display_name',trans('admin.display_name')) !!}
        {!! Form::text('display_name',$role->display_name,['class'=>'form-control']) !!}
     </div>
     <div class="form-group">
        {!! Form::label('description',trans('admin.description')) !!}
        {!! Form::textarea('description',$role->description,['class' => 'form-control' ]) !!}
       
     </div>
     <div class="form-group">
        <label for="name">الصلاحيات</label><br>
        <input id="select-all" type="checkbox"><label for='select-all'>اختيار الكل</label>
        <br>
        <div class="row">
            @foreach($perm->all() as $permission)
                <div class="col-sm-3">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="permissions_list[]" value="{{$permission->id}}"
                            @if($role->hasPermission($permission->name))
                                checked
                            @endif
                            >
                            {{$permission->display_name}}
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