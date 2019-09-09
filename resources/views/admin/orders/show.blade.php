@extends('admin.index')
@section('title')
    Admin
@endsection
@section('sub_title')
   {{trans('admin.order_show')}} 
@endsection
@section('back')
  <li><a href="{{aurl('orders')}}" class="btn btn-info">{{trans('admin.back')}}</a></li>
@endsection
@section('content')


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

        @if(!empty($order))
                <section class="invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> تفاصيل طلب # {{$order->id}}
                                <small class="pull-left"><i class="fa fa-calendar-o"></i>  {{$order->created_at}}
                                </small>
                            </h2>
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            طلب من
                            <address>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>الاسم:  @if($order->client->count()){{$order->client->name}}@endif
                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>   الهاتف : @if($order->client->count()){{$order->client->phone}}@endif
                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>  البريد الإلكترونى : @if($order->client->count()){{$order->client->email}}@endif
                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>  العنوان : {{$order->address}}
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            المطعم :
                            <address>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>الاسم :  @if($order->restaurant->count()){{$order->restaurant->name}}@endif<br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>الايميل :  @if($order->restaurant->count()) {{$order->restaurant->email}}@endif
                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>  الهاتف :  @if($order->restaurant->count()) {{$order->restaurant->phone}}@endif
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <i class="fa fa-angle-left" aria-hidden="true"></i> رقم الفاتورة  #{{$order->id}}<br>
                            <i class="fa fa-angle-left" aria-hidden="true"></i>  حالةالطلب: {{$order->status}}  <br>
                            <i class="fa fa-angle-left" aria-hidden="true"></i> الإجمالى: {{$order->total_price}}
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>إسم المنتج</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>ملاحظة</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $count = 1; @endphp
                                @foreach($order->meals as $meal)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{$meal->name}}</td>
                                    <td>{{$meal->pivot->quantity}}</td>
                                    <td>{{$meal->pivot->price}}</td>
                                    <td>{{$meal->pivot->special_order}}</td>

                                </tr>
                                @php $count ++; @endphp
                                    @endforeach
                                <tr>
                                    <td>--</td>
                                    <td>تكلفة التوصيل</td>
                                    <td>-</td>
                                    <td>{{$order->delivery_cost}}</td>
                                    <td></td>
                                </tr>
                                <tr class="bg-success">
                                    <td>--</td>
                                    <td>الإجمالي</td>
                                    <td>-</td>
                                    <td>
                                            {{$order->total_price}}  ريال سعودى
                                    </td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                  
                </section><!-- /.content -->
                <div class="clearfix"></div>
            @endif
        </div>
    </div>

    
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