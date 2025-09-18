@extends('user.layout.navbar')
@section('content')
<style>
    .active {
        background-color: #4bb750;

    }

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
</style>



<div class="main-content">
  



<div class="breadcrumb">
     <h1 class="mr-2">Dashboard</h1>
     
        <?php
        if($missingData){
            ?>
            <span class="text-danger"><b class="text-danger">!Important missing file.</b> 
            -> <?php echo $missingData; ?>
            </span>  
        <?php } ?>
       
    </div>
  


<div class="row">
        <div class="col-md-7 col-lg-7 mt-4">
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
                
                
                <div class="col-md-5 col-lg-5 mt-4">
           
                                <div class="card">
                                    <div class="card-body">
                                        <div class="ul-widget__head">
                                            <div class="ul-widget__head-label">
                                                <h3 class="ul-widget__head-title"><b>Announcements</b></h3>
                                            </div>
                                            <div class="ul-widget__head-toolbar">
                                                <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line" role="tablist">
                                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#__g-widget-s7-tab1-content" role="tab" aria-selected="true">Latest</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#__g-widget-s7-tab2-content" role="tab" aria-selected="false">Recent</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="ul-widget__body">
                                            <div class="tab-content">
                                                <div class="tab-pane active show" style="background-color:white" id="__g-widget-s7-tab1-content">
                                                    <div class="ul-widget-s7n">

                  @if(count($messages) > 0)
            
                
                                                        <div class="ul-widget-s7__items mb-4"><span class="ul-widget-s7__item-time ul-middle" style="font-size:13px;">{{ $messages->last()->created_at->format('Y-m-d') }}</span>
                                                            <div class="ul-widget-s7__item-circle">
                                                                <p class="ul-vertical-line bg-primary"></p>
                                                            </div>
                                                            <div class="ul-widget-s7__item-text text-danger">
                                                               {{ $messages->last()->message }}
                                                            </div>
                                                        </div>
                                                       
                                                  
            
        @else
            <p>No messages found.</p>
        @endif     
                                                     
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="__g-widget-s7-tab2-content" style="background-color:white">
                                                    <div class="ul-widget-s7n">
                                                        @if(count($messages) > 0)
            
                @foreach($messages->reverse() as $message)  
                                                        <div class="ul-widget-s7__items mb-4"><span class="ul-widget-s7__item-time ul-middle" style="font-size:13px;">{{ $message->created_at->format('Y-m-d') }}</span>
                                                            <div class="ul-widget-s7__item-circle">
                                                                <p class="ul-vertical-line bg-danger"></p>
                                                            </div>
                                                            <div class="ul-widget-s7__item-text">
                                                               {{ $message->message }}
                                                            </div>
                                                        </div>
                                                     @endforeach
            
        @else
            <p>No messages found.</p>
        @endif
                                                      
                                                      
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                            </div></div> 
                                                            
                                                            <br>

 <b class="my-4">!Please provide your & project details first  by following these steps.</b>
   <ol>
        <div class="row">
        <div class="col-5"><li>Go to Upload BV Details<a href="{{ route('user.bvdetails') }}"><button class="btn btn-primary btn-sm custom-btn mx-2" name="submit" type="submit">UploadData</button></a></li></div>
        
        <div class="col-5"><li>Go to Upload Data Fill Form and submit<a href="{{ route('user.projectform') }}"><button class="btn btn-primary btn-sm custom-btn mx-2" name="submit" type="submit">UploadData</button></a></li></div>
        
        <div class="col-5 mt-2"><li>Go to Upload files to upload neccessary files<a href="{{ route('user.file') }}"><button class="btn btn-primary btn-sm custom-btn mx-2 " name="submit" type="submit">UploadFiles</button></a></li></div>
        
        <div class="col-5 mt-2"><li>Go to Add categories to add catagory<a href="{{ route('user.catagory') }}"><button class="btn btn-primary btn-sm custom-btn mx-2 " name="submit" type="submit">Catagory</button></a></li></div>
        
        <div class="col-5 mt-2"><li>Go to Minisite Portfolio to select minisite design<a href="{{ route('user.design') }}"><button class="btn btn-primary btn-sm custom-btn mx-2" name="submit" type="submit">Minisite</button></a></li></div>
        
        </div>
    </ol>

    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-4">

        <div class="col-md-3 col-lg-3"><a href="{{ route('user.projectdetail') }}">
            <div class="card mb-4 o-hidden" data-route="user.projectdetail">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        {{--  <h5 class="heading">INCOME</h5>  --}}
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Project</h2><small >see your projects progress >> click here</small>
                        </div>
                    </div>
                    {{--  <div id="basicArea-chart"></div>  --}}
                </div>
            </div></a>
                </div>
                <div class="col-md-3 col-lg-3">
                <a href="{{ route('user.payment') }}">
            <div class="card mb-4 o-hidden" data-route="user.payment">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        {{--  <h5 class="heading">APPROVE</h5>  --}}
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Billing</h2><small >see your invoices >> click here</small>
                        </div>
                    </div>
                    {{--  <div id="basicArea-chart2"></div>  --}}
                </div>
            </div></a>
        </div>


        <div class="col-md-3 col-lg-3">
                <a href="{{ route('user.training') }}">
            <div class="card mb-4 o-hidden" data-route="user.catagory">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        {{--  <h5 class="heading">transaction</h5>  --}}
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Training</h2><small >professional training videos >> click here</small>
                        </div>
                    </div>
                    {{--  <div id="basicArea-chart3"></div>  --}}
                </div>
            </div>
                </a></div>
                
                 <div class="col-md-3 col-lg-3">
                <a href="{{ route('user.complain') }}">
            <div class="card mb-4 o-hidden" data-route="user.complain">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                       {{--  <h5 class="heading">SALES</h5>  --}}
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Ticket</h2><small >generate ticket in case of any delay >> click here</small>
                        </div>
                    </div>
                    {{--  <div id="basicArea-chart4"></div>  --}}
                </div>
            </div></a>
        </div>
        
           
              
               </div>
           
        <!-- finance-->
         
                            
        </div>
                </div>
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
