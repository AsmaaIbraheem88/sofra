
@extends('admin.index')
@section('title')
  Dashboard
@endsection
@section('sub_title')
   {{trans('admin.dashboard')}} 
@endsection

@inject('restaurant','App\Models\Restaurant')
@inject('order','App\Models\Order')
@inject('client','App\Models\Client')
<?php
    $usersCount = $client->all()->count();
    $ordersCount = $order->where('status','!=','pending')->get()->count();
    $restaurantCount = $restaurant->all()->count();
?>
@section('content')
        <!-- Info boxes -->
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-cutlery"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{trans('admin.restaurant_count')}}</span>
                <span class="info-box-number">{{$restaurantCount}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{trans('admin.complet_order_count')}}</span>
                <span class="info-box-number">{{$ordersCount}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{trans('admin.users_count')}}</span>
                <span class="info-box-number">{{$usersCount}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

</div>
<!-- /.row -->
@endsection
