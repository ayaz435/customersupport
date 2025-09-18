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
    <div class="breadcrumb">
        <h1> Fill Form Details</h1>

    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row" id="comma_decimal">
        <div class="col-lg-12 col-md-12">

            <div class="card mt-4">
                <div class="card-body">
                    <!-- right control icon-->
                    @if(session('success'))
                    <div id="flash-message" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                    <div class="col-md-12" >
                        <div class="card mb-4">
                            <div class="card-body">
                                {{--@if(isset($projectData['data'][0]['pro_id']))--}}
                                <form action="{{ route('user.projectformstore') }}"  method="post" enctype="multipart/form-data">@csrf
                                    <input type="hidden" name="form_identifier" value="form2">
                    
                                    <input class="form-control" id="firstName1" name="com_id" value="{{ $user->com_id}}" type="text" placeholder="Company name" hidden />
                                    <div class="card-title mb-3"> Company Basic Details Need for Account Department</div>
                                        <div class="row">
                                            <div class="col-md-6 form-group mb-3">
                                                <label for="firstName1">Company Name
                                                </label>
                                                <input class="form-control" id="firstName1" value="{{ old('cname', $formdata->cname ?? '') }}" name="cname" type="text" placeholder="Company name" />
                                                @error('cname')
                                                    <p class="invalid-feedback">{{ $message}}</p>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label for="lastName1">Contact person Name
                                                </label>
                                                <input class="form-control" id="lastName1" name="cpname" value="{{ old('cpname', $formdata->cpname ?? '') }}" type="text" placeholder="Contact Person name" />
                                                @error('cpname')
                                                    <p class="invalid-feedback">{{ $message}}</p>
                                                @enderror
                                            </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="firstName1">Proproietor/Partner
                                            </label>
                                            <input class="form-control" id="firstName1" name="ppname" value="{{ old('ppname', $formdata->ppname ?? '') }}" type="text" placeholder="Proproietor/Partner" />
                                            @error('ppname')
                                            <p class="invalid-feedback">{{ $message}}</p>
                                        @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="lastName1">NIC#
                                            </label>
                                            <input class="form-control" id="lastName1" name="nic" value="{{ old('nic', $formdata->nic ?? '') }}" type="text" placeholder="NIC#
                                            " />
                                            @error('nic')
                                            <p class="invalid-feedback">{{ $message}}</p>
                                        @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="firstName1">NTN#

                                            </label>
                                            <input class="form-control" id="firstName1" name="ntn" value="{{ old('ntn', $formdata->ntn ?? '') }}" type="text" placeholder="NTN#
                                            " />
                                            @error('ntn')
                                            <p class="invalid-feedback">{{ $message}}</p>
                                        @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                                <label for="picker1">Select Project</label>
                                                <select class="form-control" name="project">
                                                    <option value="">...</option>
                                                        @if($projectData['data'] !== 'No data found')
                                                            @foreach($projectData['data'] as $project) 
                                                                <option value="{{$project['pro_id']}}"
                                                                    {{ old('project', $formdata->project ?? '') === $project['pro_id'] ? "selected" : '' }}>
                                                                    {{$project['project']}}</option>
                                                            @endforeach
                                                        @endif    
                                                </select>
                                                @error('catagory')
                                                <p class="invalid-feedback">{{ $message}}</p>
                                            @enderror
                                            </div>
                                           <div class="col-md-6 form-group mb-3">
                                            <label for="firstName1">Email

                                            </label>
                                            <input class="form-control" id="firstName1" name="email" value="{{ old('email', $formdata->email ?? '') }}" type="text" placeholder="Email" />
                                            @error('email')
                                            <p class="invalid-feedback">{{ $message}}</p>
                                        @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="lastName1">Web

                                            </label>
                                            <input class="form-control" id="lastName1" name="web" value="{{ old('web', $formdata->web ?? '') }}" type="text" placeholder="Web" />
                                            @error('web')
                                            <p class="invalid-feedback">{{ $message}}</p>
                                        @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="firstName1">Phone

                                            </label>
                                            <input class="form-control" id="firstName1" name="phone" value="{{ old('phone', $formdata->phone ?? '') }}" type="text" placeholder="Phone
                                            " />
                                            @error('phone')
                                            <p class="invalid-feedback">{{ $message}}</p>
                                        @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="lastName1">Mobile

                                            </label>
                                            <input class="form-control" id="lastName1" name="mobile" value="{{ old('mobile', $formdata->mobile ?? '') }}" type="text" placeholder="Mobile
                                            " />
                                            @error('mobile')
                                            <p class="invalid-feedback">{{ $message}}</p>
                                        @enderror
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="lastName1">Address
                                            </label>
                                            <input class="form-control" id="lastName1" name="address" value="{{ old('address', $formdata->address ?? '') }}" type="text" placeholder="Address

                                            " />
                                            @error('address')
                                            <p class="invalid-feedback">{{ $message}}</p>
                                        @enderror
                                        </div>
                                    </div>


                                    <div class="card-title mb-3"> Project Basic Details Need for Working
                                    </div>
                                     <div class="row">

                                            <div class="col-md-6 form-group mb-3">
                                                <label for="picker1">Select Related Catagory</label>
                                                <select class="form-control" name="catagory">
                                                    <option value="">...</option>
                                                    <option value="bv" {{ old('catagory', $formdata->catagory ?? '') == 'bv' ? 'selected' : '' }}>AliBaba BV</option>
                                                    <option value="project" {{ old('catagory', $formdata->catagory ?? '') == 'project' ? 'selected' : '' }}>Project Details</option>
                                                    <option value="other" {{ old('catagory', $formdata->catagory ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                                @error('catagory')
                                                <p class="invalid-feedback">{{ $message}}</p>
                                            @enderror
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label for="firstName1">Company Profile (About Us)

                                                </label>
                                                <input class="form-control" id="firstName1" name="cpabout" value="{{ old('cpabout', $formdata->cpabout ?? '') }}" type="text" placeholder="Company Profile
                                                " />
                                                @error('cpabout')
                                                <p class="invalid-feedback">{{ $message}}</p>
                                            @enderror
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label for="firstName1">Referance website
                                                </label>
                                                <input class="form-control" id="firstName1" name="rwebsite" value="{{ old('rwebsite', $formdata->rwebsite ?? '') }}" type="text" placeholder="Referance website

                                                " />
                                                @error('rwebsite')
                                                <p class="invalid-feedback">{{ $message}}</p>
                                            @enderror
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label for="firstName1">Color Scheeme
                                                </label>
                                                <input class="form-control" id="firstName1" name="color" value="{{ old('color', $formdata->color ?? '') }}"  type="text" placeholder="Color Scheeme
                                                " />
                                                @error('color')
                                                <p class="invalid-feedback">{{ $message}}</p>
                                            @enderror
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label for="firstName1">Your Website
                                                </label>
                                                <input class="form-control" id="firstName1" name="ywebsite" value="{{ old('ywebsite', $formdata->ywebsite ?? '') }}"  type="text" placeholder="Your Website
                                                " />
                                                @error('ywebsite')
                                                <p class="invalid-feedback">{{ $message}}</p>
                                            @enderror
                                            </div>

                                        </div>

                                    <div class="col-md-12">
                                            <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                        </div>
                                </form>
{{--                                                @else--}}
{{--                                                <b>No project data found please start a project first</b>--}}
{{--                                                @endif--}}
                            </div>
                        </div>
                    </div>
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
