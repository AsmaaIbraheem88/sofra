<header class="main-header">
    <!-- Logo -->
    <a href="{{ aurl('') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">{{config('app.name')}}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        
           <!-- User Account: style can be found in dropdown.less -->
           <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <i class="fa fa-globe"></i> -->
              <span class="hidden-xs">languages</span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{ aurl('lang/ar') }}"><i class="fa fa-flag"></i> عربى</a></li>
              <li><a href="{{ aurl('lang/en') }}"><i class="fa fa-flag"></i> English</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('adminlte/dist/img/user11.jpg')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{optional(admin()->user())->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset('adminlte/dist/img/user11.jpg')}}" class="img-circle" alt="User Image">

                <p>
                {{optional(admin()->user())->name}}
                 
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                 
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ aurl('admin/'.admin()->user()->id.'/edit') }}" class="btn btn-default btn-flat">{{trans('admin.profile')}}</a>
                </div>
                <div class="pull-right">
                  <a href="{{url('admin/logout')}}" class="btn btn-default btn-flat">{{trans('admin.Sign_out')}}</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
        <li> <a href="{{ aurl('') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('admin.dashboard') }}</span> </a> </li>


        <li class="treeview  {{ active_menu('admin')[0] }}">
          <a href="#">
            <i class="fa fa-users"></i> <span>{{ trans('admin.admin') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="{{ active_menu('admin')[1] }}">
            <li class=""><a href="{{ aurl('admin') }}"><i class="fa fa-circle"></i> {{ trans('admin.admin') }}</a></li>
            
            <li class=""><a href="{{ aurl('roles') }}"><i class="fa fa-circle"></i> {{ trans('admin.roles') }}</a></li>
          </ul>
        </li>


        <li><a href="{{ aurl('categories') }}"><i class="fa fa-book"></i> <span>{{ trans('admin.categories') }}</span></a></li>


        <li><a href="{{ aurl('cities') }}"><i class="fa fa-flag"></i> <span>{{ trans('admin.cities') }}</span></a></li>


        <li> <a href="{{ aurl('districts') }}"><i class="fa fa-list-ul"></i> <span>{{ trans('admin.districts') }}</span> </a> </li>



        <li class="treeview {{ active_menu('restaurants')[0] }}"" >
          <a href="#">
            <i class="fa fa-cutlery"></i> <span>{{ trans('admin.restaurants') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="{{ active_menu('restaurants')[1] }}">
            <li class=""><a href="{{ aurl('restaurants') }}"><i class="fa fa-circle"></i> {{ trans('admin.restaurants') }}</a></li>
            <li class=""><a href="{{ aurl('payments') }}"><i class="fa fa-circle"></i> {{ trans('admin.payments') }}</a></li>
            <li class=""><a href="{{ aurl('offers') }}"><i class="fa fa-circle"></i> {{ trans('admin.offers') }}</a></li>
          </ul>
        </li>



        <li ><a href="{{ aurl('settings') }}"><i class="fa fa-cog"></i> <span>{{ trans('admin.settings') }}</span> </a> </li>
        <li><a href="{{ aurl('contacts') }}"><i class="fa fa-envelope"></i> <span>{{ trans('admin.contacts') }}</span> </a> </li>
       <li><a href="{{ aurl('clients') }}"><i class="fa fa-users"></i> <span>{{ trans('admin.clients') }}</span> </a> </li>
       <li><a href="{{ aurl('orders') }}"><i class="fa fa-tasks"></i> <span>{{ trans('admin.orders') }}</span> </a> </li>
       <li><a href="{{aurl('change-password')}}"><i class="fa fa-key"></i>{{ trans('admin.change_password') }}</a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
