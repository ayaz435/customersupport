
@extends('admin.layout.navbar')
@section('content')
<style>
   
    .custom-btn {
        font-size: 10px; /* Reduce font size */
        padding: 3px; /* Adjust padding for smaller size */
    }

    .ul-widget__body {
            max-height: 300px; /* Adjust the height as needed */
            overflow-y: auto;
        }


    .slider {
        overflow: hidden;
        width: 300px; /* Set your desired width */
        height: 200px; /* Set your desired height */
        position: relative;
    }

    .slider-inner {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .slide {
        flex: 0 0 100%; /* Make each slide take full width */
        transition: transform 0.5s ease-in-out;
    }
</style>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Admin Dashboard</h1>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li>Version 4</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-4">
        <div class="col-md-3 col-lg-3">
            <a href="{{route('admin.registeredusers')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <h5 class="heading">Total InService Customer</h5>
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">
                            {{$userCount}}
                            </h2>
                            <small class="text-muted"></small>
                        </div>
                    </div>
                    <div id="basicArea-chart"></div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-3 col-lg-3">
            <a href="{{route('admin.registeredteammembers')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <h5 class="heading">Total Team Members</h5>
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">{{$teamCount}}</h2><small class="text-muted"></small>
                        </div>
                    </div>
                    <div id="basicArea-chart3"></div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-3 col-lg-3">
            <a href="{{route('admin.chats.chatsfetch')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <h5 class="heading">Total Late Replies</h5>
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">{{ $responses['totalLateMessagesCount'] }}</h2><small class="text-muted"></small>
                        </div>
                    </div>
                    <div id="basicArea-chart4"></div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-3 col-lg-3">
            <a href="{{route('admin.complain')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        <h5 class="heading">Total Tickets</h5>
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">{{$ticket}}</h2><small class="text-muted"></small>
                        </div>
                    </div>
                    <div id="basicArea-chart2"></div>
                </div>
            </div>
            </a>
        </div>

        <!-- finance-->
      
        <div class="col-lg-8 col-md-12 mt-4">
            <div class="card o-hidden" style="height: 42vh">
                <div class="card text-left">
                    @isset($imagePath)
                    <div class="card-body">
                        <h2 class="t-font-boldest">Promotion</h2>

                        <div class="table-responsive">



<div class="slider w-100">
  <div class="slider-inner w-100">
@foreach($data as $item)
@if(isset($item['img']))

    <div class="slide w-100"><img src="{{ $imagePath }}" alt="Slide 1"></div>
@endif
@endforeach
  </div>
</div>

                        </div>
                    </div>

                @else
                    
                @endisset

                </div>
            </div>
            
           
            
        </div>
       
                          
        <div class="col-lg-4 col-md-6 col-xl-4 mt-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="ul-widget__head">
                        <div class="ul-widget__head-label">
                            <h3 class="ul-widget__head-title">Late Replies</h3>
                        </div>
                        
                    </div>
                    <div class="ul-widget__body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="__g-widget4-tab1-content">
                                <div class="ul-widget1">
                            
                                @foreach($responses['usersWithLateReplies'] as $userWithLateReplies)
                                    <div class="ul-widget4__item ul-widget4__users">
                                        <div class="ul-widget4__img"><img id="userDropdown" src="../../dist-assets/images/faces/1.jpg" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" /></div>
                                        <div class="ul-widget2__info ul-widget4__users-info"><a class="ul-widget2__title" href="#">{{ $userWithLateReplies->name }}</a><span class="ul-widget2__username" href="#">Late Replies Count: {{ $userWithLateReplies->late_messages_count }}</span></div>
                                        <div class="ul-widget4__actions">
                                           <a href="{{ route('admin.chats.chatsfetch') }}"><button class="btn btn-outline-danger m-1" type="button">Detail</button></a>
                                        </div>
                                    </div>
                                @endforeach   
                                
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
     
      
        <!-- end of col-->
    </div>
    <!-- end of row-->
    <!-- end of main-content -->
</div>

                             <script>
  let currentIndex = 0;
  const slides = document.querySelectorAll('.slide');
  const totalSlides = slides.length;
  const slideWidth = slides[0].clientWidth;

  function goToSlide(index) {
    const newPosition = -index * slideWidth;
    document.querySelector('.slider-inner').style.transform = `translateX(${newPosition}px)`;
    currentIndex = index;
  }

  function nextSlide() {
    if (currentIndex < totalSlides - 1) {
      goToSlide(currentIndex + 1);
    } else {
      goToSlide(0);
    }
  }

  setInterval(nextSlide, 3000); // Change slide every 3 seconds
</script>                           
@endsection
