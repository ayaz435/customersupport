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
  <b>!Please provide your & project details first  by following these steps.</b>

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
    <div class="row">

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
            <div class="card mb-4 o-hidden" data-route="user.training">
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
        

<div class="main-content">
    <!--<div class="breadcrumb">-->
    <!--    <h1>Send us Your Files/Images</h1>-->

    <!--</div>-->
    <!--<b>!Please Send us all files or that defines below we can't start your project till we have your data.</b>-->

    <!--<ol>-->
    <!--    <li>Company logo PNG</li>-->
    <!--    <li>Quality Certificates</li>-->
    <!--    <li>Membership Certificates</li>-->
    <!--    <li>Factory Production Pictures</li>-->
    <!--    <li>Expo (Trade Show)</li>-->
    <!--    <li>Banners Product Picture</li>-->
    <!--</ol>-->
    <!--<div class="separator-breadcrumb border-top"></div>-->
    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="card ">
                <div class="card-body">
                    <!-- right control icon-->
                    @if(session('success'))
                    <div id="flash-message" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                

                                {{-- <form action="{{ route('user.fileupload') }}" method="post" enctype="multipart/form-data" id="comma_decimal">
                                    @csrf
                                    <div class="card-title mb-0">Send Us Your Documents</div>
                                    <b style="color:red">!Please upload your below required documents to get start working on your projects.</b>
                                    <div class="row mt-3">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="files">Uploads</label>
                                            <input class="form-control" id="files" name="files[]" type="file" placeholder="" multiple />
                                            @error('files.*')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                    </div>
                                </form>--}}
                                
{{--                                <form action="{{ route('user.fileupload') }}" method="post" enctype="multipart/form-data" id="comma_decimal">
                                    @csrf
                                    <div class="card-title mb-3">Upload Required Files</div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="logo">Company Logo (PNG)</label>
                                            <input class="form-control" id="logo" name="logo" type="file"  accept=".png" />
                                            
                                                
                                    
                                    
                                            @error('logo')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="quality_cert">Quality Certificates</label>
                                            <input class="form-control" id="quality_cert" name="quality_cert" type="file" />
                                            @error('quality_cert')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="membership_cert">Membership Certificates</label>
                                            <input class="form-control" id="membership_cert" name="membership_cert" type="file" />
                                            @error('membership_cert')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="factory_pics">Factory Production Pictures</label>
                                            <input class="form-control" id="factory_pics" name="factory_pics" type="file" />
                                            @error('factory_pics')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="expo_pics">Expo (Trade Show)</label>
                                            <input class="form-control" id="expo_pics" name="expo_pics" type="file" />
                                            @error('expo_pics')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="banners">Banners Product Picture</label>
                                            <input class="form-control" id="banners" name="banners" type="file" />
                                            @error('banners')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                    </div>
                                </form>
                                
--}}         
                                <form action="{{ route('user.fileupload') }}" method="post" enctype="multipart/form-data" id="comma_decimal">
                                    @csrf
                                    <div class="card-title mb-0">Send Us Your Documents</div>
                                    <b style="color:red">!Please upload your below required documents to get start working on your projects.</b>
                                    <div class="row mt-3">
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="logo">Company Logo (PNG)</label>
                                            <input class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" type="file" accept=".png" />
                                            @if(isset($filedata['logo']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['logo']->file) }}" target="_blank">
                                                        {{ $filedata['logo']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('logo')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="quality_cert">Quality Certificates</label>
                                            <input class="form-control @error('quality_cert') is-invalid @enderror" id="quality_cert" name="quality_cert" type="file" />
                                            @if(isset($filedata['quality_cert']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['quality_cert']->file) }}" target="_blank">
                                                        {{ $filedata['quality_cert']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('quality_cert')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="membership_cert">Membership Certificates</label>
                                            <input class="form-control @error('membership_cert') is-invalid @enderror" id="membership_cert" name="membership_cert" type="file" />
                                            @if(isset($filedata['membership_cert']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['membership_cert']->file) }}" target="_blank">
                                                        {{ $filedata['membership_cert']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('membership_cert')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="factory_pics">Factory Production Pictures</label>
                                            <input class="form-control @error('factory_pics') is-invalid @enderror" id="factory_pics" name="factory_pics" type="file" />
                                            @if(isset($filedata['factory_pics']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['factory_pics']->file) }}" target="_blank">
                                                        {{ $filedata['factory_pics']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('factory_pics')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="expo_pics">Expo (Trade Show)</label>
                                            <input class="form-control @error('expo_pics') is-invalid @enderror" id="expo_pics" name="expo_pics" type="file" />
                                            @if(isset($filedata['expo_pics']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['expo_pics']->file) }}" target="_blank">
                                                        {{ $filedata['expo_pics']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('expo_pics')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="banners">Banners Product Picture</label>
                                            <input class="form-control @error('banners') is-invalid @enderror" id="banners" name="banners" type="file" />
                                            @if(isset($filedata['banners']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['banners']->file) }}" target="_blank">
                                                        {{ $filedata['banners']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('banners')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                    </div>
                                
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                    </div>
                                </form>
</div>
                        </div>
                    </div>
                    <!-- /right control icon-->
                </div>
            </div>
        </div>

    </div><!-- end of main-content -->
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the current route
        var currentRoute = "{{ Route::currentRouteName() }}";

        // Get all card elements
        var cards = document.querySelectorAll('.card');

        // Loop through each card and check if its route matches the current route
        cards.forEach(function(card) {
            var cardRoute = card.getAttribute('data-route');

            if (cardRoute === currentRoute) {
                card.classList.add('active'); // Add active class if the route matches
                // Change text color of h2 and small elements
                var cardTitle = card.querySelector('.ul-widget__chart-number h2');
                var cardDescription = card.querySelector('.ul-widget__chart-number small');
                cardTitle.style.color = '#ffffff'; // Change h2 text color to white (or any other color you prefer)
                cardDescription.style.color = '#ffffff'; // Change small text color to white (or any other color you prefer)
            }
        });
    });
</script>
<script>
var dataTableSection = document.getElementById('comma_decimal');
        if (dataTableSection) {
            dataTableSection.scrollIntoView(); // Smooth scroll to the section
        }
</script>
@endsection
