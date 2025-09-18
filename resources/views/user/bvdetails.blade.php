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
    <div class="row ">

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
        

<div class="main-content ">
    <!--<div class="breadcrumb">-->
    <!--    <h1>Send us Your Files/Images</h1>-->

    <!--</div>-->
    <!--<b>!Please Send us all files or that defines below we can't start your project till we have your data.</b>-->

    <!--<ol>-->
        




    <!--    <li>Company NTN</li>-->
    <!--    <li>Latest 181 Form</li>-->
    <!--    <li>Bank Statement</li>-->
    <!--    <li>Phone Bill/Notery</li>-->
    <!--    <li>ID Card Front Side</li>-->
    <!--    <li>ID Card Back Side</li>-->
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

                                <form action="{{ route('user.bvdetailupload') }}" method="post" enctype="multipart/form-data" id="comma_decimal">
                                    @csrf
                                    <div class="card-title mb-0">Send Us Your Documents</div>
                                        <b style="color:red">!Please upload your below required documents to get start working on your projects.</b>
                                    <div class="row mt-3">
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="com_ntn">Company NTN</label>
                                            <input class="form-control @error('logo') is-invalid @enderror" id="com_ntn" name="com_ntn" type="file" accept=".png" />
                                            @if(isset($filedata['com_ntn']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['com_ntn']->file) }}" target="_blank">
                                                        {{ $filedata['com_ntn']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('com_ntn')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="form_181">Latest 181 Form</label>
                                            <input class="form-control @error('quality_cert') is-invalid @enderror" id="form_181" name="form_181" type="file" />
                                            @if(isset($filedata['form_181']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['form_181']->file) }}" target="_blank">
                                                        {{ $filedata['form_181']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('form_181')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="bank_statement">Bank Statement</label>
                                            <input class="form-control @error('membership_cert') is-invalid @enderror" id="bank_statement" name="bank_statement" type="file" />
                                            @if(isset($filedata['bank_statement']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['bank_statement']->file) }}" target="_blank">
                                                        {{ $filedata['bank_statement']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('bank_statement')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="bill">Phone Bill/Notery</label>
                                            <input class="form-control @error('factory_pics') is-invalid @enderror" id="bill" name="bill" type="file" />
                                            @if(isset($filedata['bill']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['bill']->file) }}" target="_blank">
                                                        {{ $filedata['bill']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('bill')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="id_card_front">ID Card Front Side</label>
                                            <input class="form-control @error('expo_pics') is-invalid @enderror" id="id_card_front" name="id_card_front" type="file" />
                                            @if(isset($filedata['id_card_front']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['id_card_front']->file) }}" target="_blank">
                                                        {{ $filedata['id_card_front']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('id_card_front')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="id_card_back">ID Card Back Side</label>
                                            <input class="form-control @error('banners') is-invalid @enderror" id="id_card_back" name="id_card_back" type="file" />
                                            @if(isset($filedata['id_card_back']))
                                                <p>Previously uploaded:
                                                    <a href="{{ asset('files/' . $filedata['id_card_back']->file) }}" target="_blank">
                                                        {{ $filedata['id_card_back']->file }}
                                                    </a>
                                                </p>
                                            @endif
                                            @error('id_card_back')
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
