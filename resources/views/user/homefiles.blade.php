@extends('layout.app')
@section('content')
<style>
    .active {
        background-color: #4bb750;

    }

.custom-btn {
    font-size: 10px; /* Reduce font size */
    padding: 3px; /* Adjust padding for smaller size */
}
.tick-mark {
    
    background-color: green;
    color: white;
    border-radius: 50%;
    padding: 5px;
    width: 20px;
    height: 20px;
    text-align: center;
    font-size: 7px;
    line-height: 20px;
    font-weight: bold;
    border: 2px solid white;
}


</style>
<div class="main-content">

<div class="main-content mt-5">
    <div class="breadcrumb">
        <h1>Send us Your Files/Images</h1>
        
        <?php
        if($missingData){
            ?>
            <span class="text-danger"><b class="text-danger">!Important missing file.</b> 
            -> <?php echo $missingData; ?>
            </span>  
        <?php } ?>

    </div>
    <b>!Please Send us all files or that defines below we can't start your project till we have your data.</b>

    <ol>
    <li>
    Company logo PNG 
    @if(isset($matchedValues['Companylogo']))
        <span class="tick-mark">✔</span>
    @endif
</li>
<li>
Quality Certificates
    @if(isset($matchedValues['QualityCertificates']))
        <span class="tick-mark">✔</span>
    @endif
</li>
<li>
Membership Certificates
    @if(isset($matchedValues['MembershipCertificates']))
        <span class="tick-mark">✔</span>
    @endif
</li>
<li>
Factory Production Pictures 
    @if(isset($matchedValues['FactoryProductionPictures']))
        <span class="tick-mark">✔</span>
    @endif
</li>
<li>
Expo (Trade Show)
    @if(isset($matchedValues['ExpoTradeShow']))
        <span class="tick-mark">✔</span>
    @endif
</li>
<li>
BannersProductPicture
    @if(isset($matchedValues['BannersProductPicture']))
        <span class="tick-mark">✔</span>
    @endif
</li>

    
    </ol>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="card mt-4">
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
                          
                                <form action="{{ route('homeuser.fileupload') }}" method="post" enctype="multipart/form-data" id="comma_decimal">
                                    @csrf
                                    <input class="form-control" id="files" value="{{$project}}" name="projectid" type="number"  hidden/>
                                    <div class="card-title mb-3">Upload Required Files</div>
                                    <div class="row">
                                       <div class="col-md-6 form-group mb-3">
                                            <label for="files"><span class="text-danger">*</span>Select File Type</label>
                                            <select class="form-control" required name="filetype">
                                    <option value="">Select file type you want submit.....</option>
                                            <option value="Companylogo">Company logo</option>
                                            <option value="QualityCertificates">Quality Certificates</option>
                                            <option value="MembershipCertificates">Membership Certificates</option>
                                            <option value="FactoryProductionPictures">Factory Production Pictures</option>
                                            <option value="ExpoTradeShow">Expo (Trade Show)</option>
                                             <option value="BannersProductPicture">Banners Product Picture</option>
                                            </select>
                                            @error('files.*')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="files"><span class="text-danger">*</span>Uploads</label>
                                            <input class="form-control" id="files" name="files[]" type="file" placeholder="" multiple required />
                                            @error('files.*')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                     
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{route('user.dashboard')}}">Skip</a>
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
