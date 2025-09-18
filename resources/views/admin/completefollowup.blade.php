
@extends('admin.layout.navbar')
@section('content')


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Admin Dashboard</h1>
        <ul>
            <li><a href="#">Clients For Follow Up Completed Task</a></li>
            <li>Version 4</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-4">
        
        <div class="col-md-4 col-lg-4">
            <a href="{{route('admin.completefollowup3')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <h5 class="heading">Customers 3 months old</h5>
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Total Completed Tasks</h2><span class="fs-5"><b>{{$count1}}</b></span>
                        </div>
                    </div>
                    <div id="basicArea-chart2"></div>
                </div>
            </div>
        </a>
        </div>
        <div class="col-md-4 col-lg-4">
            <a href="{{route('admin.completefollowup6')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <h5 class="heading">Customers 6 months old</h5>
                        <div class="ul-widget__chart-number">
                        <h2 class="t-font-boldest">Total Completed Tasks</h2><span class="fs-5"><b>{{$count2}}</b></span>
                        </div>
                    </div>
                    <div id="basicArea-chart3"></div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-4 col-lg-4">
            <a href="{{route('admin.completefollowup9')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <h5 class="heading">Customers 1 Year old</h5>
                        <div class="ul-widget__chart-number">
                        <h2 class="t-font-boldest">Total Completed Tasks</h2><span class="fs-5"><b>{{$count3}}</b></span>
                        </div>
                    </div>
                    <div id="basicArea-chart4"></div>
                </div>
            </div>
            </a>
        </div>
        <!-- finance-->
      
      
        <!-- end of col-->
    </div>
    <!-- end of row-->
    <!-- end of main-content -->
</div>

                                         
@endsection
