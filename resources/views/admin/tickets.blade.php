
@extends('admin.layout.navbar')
@section('content')


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Admin Dashboard</h1>
        <ul>
            <li><a href="#">Clients Tickets</a></li>
            <li>Version 4</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-4">
        <div class="col-md-4 col-lg-4">
            <a href="{{route('admin.completedtickets')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <!--<h5 class="heading">Customers 3 months old</h5>-->
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Total Completed Tickets Against Team</h2><span class="fs-5"><b>{{$count1}}</b></span>
                        </div>
                    </div>
                    <div id="basicArea-chart2"></div>
                </div>
            </div>
        </a>
        </div>
        <div class="col-md-4 col-lg-4">
            <a href="{{route('admin.pendingtickets')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <!--<h5 class="heading">Customers 6 months old</h5>-->
                        <div class="ul-widget__chart-number">
                        <h2 class="t-font-boldest">Total In Progress Tickets Against Team</h2><span class="fs-5"><b>{{$count2}}</b></span>
                        </div>
                    </div>
                    <div id="basicArea-chart3"></div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-4 col-lg-4">
            <a href="{{route('admin.receivedticktets')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <!--<h5 class="heading">Customers 1 Year old</h5>-->
                        <div class="ul-widget__chart-number">
                        <h2 class="t-font-boldest">Total Received Tickets Against Team</h2><span class="fs-5"><b>{{$count3}}</b></span>
                        </div>
                    </div>
                    <div id="basicArea-chart4"></div>
                </div>
            </div>
            </a>
        </div>
        {{--
            <div class="col-md-4 col-lg-4">
                <a href="{{route('services.tickets')}}">
                    <div class="card mb-4 o-hidden">
                        <div class="card-body ul-card__widget-chart">
                            <div class="ul-widget__chart-info">
                                <!--<h5 class="heading">Customers 1 Year old</h5>-->
                                <div class="ul-widget__chart-number">
                                <h2 class="t-font-boldest">Total Tickets Against Services</h2><span class="fs-5"><b>{{$count4}}</b></span>
                                </div>
                            </div>
                            <div id="basicArea-chart"></div>
                        </div>
                    </div>
                </a>
            </div>
        --}}
    </div>
    <div class="row mb-4">
        <div class="col-md-4 col-lg-4">
            <a href="{{route('services.completedtickets')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <!--<h5 class="heading">Customers 3 months old</h5>-->
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Total Completed Tickets Against Services</h2><span class="fs-5"><b>{{$count5}}</b></span>
                        </div>
                    </div>
                    <div id="basicArea-chart5"></div>
                </div>
            </div>
        </a>
        </div>
        <div class="col-md-4 col-lg-4">
            <a href="{{route('services.pendingtickets')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <!--<h5 class="heading">Customers 6 months old</h5>-->
                        <div class="ul-widget__chart-number">
                        <h2 class="t-font-boldest">Total In Progress Tickets Against Services</h2><span class="fs-5"><b>{{$count6}}</b></span>
                        </div>
                    </div>
                    <div id="basicArea-chart6"></div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-4 col-lg-4">
            <a href="{{route('services.receivedticktets')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <!--<h5 class="heading">Customers 1 Year old</h5>-->
                        <div class="ul-widget__chart-number">
                        <h2 class="t-font-boldest">Total Received Tickets Against Services</h2><span class="fs-5"><b>{{$count7}}</b></span>
                        </div>
                    </div>
                    <div id="basicArea-chart7"></div>
                </div>
            </div>
            </a>
        </div>
    </div>
    
    <!-- end of row-->
    <!-- end of main-content -->
</div>

                                         
@endsection
