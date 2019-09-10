@extends('admin.index')
@section('title')
Restaurants
@endsection
@section('sub_title')
   {{trans('admin.restaurant_show')}} 
@endsection
@section('back')
  <li><a href="{{aurl('restaurants')}}" class="btn btn-info">{{trans('admin.back')}}</a></li>
@endsection
@section('content')

 <!-- 'name', 'email', 'phone', 'district_id', 'minimum_charge', 'delivery_cost', 'whatsapp', 'image', 'status' -->
<div class="box box-primary">
  <div class="box-header">
    <div class="pull-right">
        <button  onclick="print()"  target="_blank" class="btn btn-default">
            <i class="fa fa-print"></i> طباعة 
        </button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body" id='printpage'>

  @if(!empty($restaurant))
 
                <section class="invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i>   تفاصيل مطعم  {{$restaurant->name}}
                                <small class="pull-left"><i class="fa fa-calendar-o"></i>  {{$restaurant->created_at}}
                                </small>
                            </h2>
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                   

                    <div class="row">  

                    <table class="table table-striped" style="font-size:25px">

                        <tr>
                        <td >{{trans('admin.name')}} : </td>
                        <td>{{$restaurant->name}}</td>
                        </tr>

                        <tr>
                        <td >{{trans('admin.email')}}: </td>
                        <td>{{$restaurant->email}}</td>
                        </tr>

                       
                        <tr>
                        <td>{{trans('admin.phone')}}:</td>
                        <td>{{$restaurant->phone}}</td> 
                        </tr>

                        <tr>
                        <td>{{trans('admin.district')}}:</td>
                        <td>{{optional($restaurant->district)->name_en}}</td> 
                        </tr>

                        <tr>
                        <td>{{trans('admin.status')}}:</td>
                        <td> {{$restaurant->status}}</td> 
                        </tr>
                        
                        <tr>
                        <td>{{trans('admin.is_active')}}:</td>
                        <td>{{$restaurant->is_active}}</td> 
                        </tr>

                        <tr>
                        <td>{{trans('admin.whatsapp')}}:</td>
                        <td>{{$restaurant->whatsapp}}</td> 
                        </tr>

                        <tr>
                        <td>{{trans('admin.minimum_charge')}}:</td>
                        <td> {{$restaurant->minimum_charge}}</td> 
                        </tr>

                        <tr>
                        <td>{{trans('admin.delivery_cost')}}:</td>
                        <td>{{$restaurant->delivery_cost}}</td> 
                        </tr>

                        <tr>
                        <td>{{trans('admin.image')}}:</td>
                        <td> <img src="{{asset('storage/restaurants/'.$restaurant->image)}}" style="width:100;height: 100px;" /> </td> 
                        </tr>
                  

                    </table>

                    </div>   
                     
                  
                   
                </section><!-- /.content -->
                <div class="clearfix"></div>
            @endif

  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->

@push('js')
<script>
    function print(){
    
        var value1=document.getElementById('printpage').innerHTML;
        var value2=document.body.innerHTML;
        document.body.innerHTML=value1;
        window.print();
        document.body.innerHTML=value2;

    }

</script>

@endpush

@endsection



