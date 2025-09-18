@extends('layout.app')
@section('content')
<style>
    .active {
        background-color: #4bb750;
    }

    .custom-btn {
        font-size: 10px;
        padding: 3px;
    }
</style>
<div class="main-content">
    <div class="breadcrumb">
        <h1> Fill Form Details</h1>
        
        <?php
        if($missingData){
            ?>
            <span class="text-danger"><b class="text-danger">!Important missing file.</b> 
            -> <?php echo $missingData; ?>
            </span>  
        <?php } ?>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <ul>
        <li><b>Please provide your and the project's details first by following the provided steps.</b></li>
        <li><b>The approximate project delivery time is one month.</b></li>
        <li><b>If there is any delay in providing required data from your side, updates on the status, or necessary permissions, the delivery timeline will be extended accordingly.</b></li>
        <li><b>If you want to skip and provide details later, you can click the "Skip" button.</b></li>
    </ul>

    <div class="mt-4">
    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill shadow-sm">
         Continue <i class="fas fa-arrow-right"></i>
    </a>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var currentRoute = "{{ Route::currentRouteName() }}";
        var cards = document.querySelectorAll('.card');
        cards.forEach(function(card) {
            var cardRoute = card.getAttribute('data-route');
            if (cardRoute === currentRoute) {
                card.classList.add('active');
                var cardTitle = card.querySelector('.ul-widget__chart-number h2');
                var cardDescription = card.querySelector('.ul-widget__chart-number small');
                if (cardTitle) cardTitle.style.color = '#ffffff';
                if (cardDescription) cardDescription.style.color = '#ffffff';
            }
        });
    });
</script>
<script>
    var dataTableSection = document.getElementById('comma_decimal');
    if (dataTableSection) {
        dataTableSection.scrollIntoView();
    }
</script>


{{--
                                <form action="{{ route('homeuser.projectformstore') }}"  method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="form_identifier" value="form2">
                                    
                                    @if(isset($projectData['data'][0]['com_id']))
                                    <input class="form-control" id="firstName1" name="com_id" value="{{ $projectData['data'][0]['com_id'] }}" type="text" placeholder="Company name" hidden />
                                    @else
                                    <div class="alert alert-warning mb-3">Company ID is not available. Please create a project first.</div>
                                    @endif
                                    
                                    <div class="card-title mb-3"> Company Basic Details Need for Account Department</div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="firstName1">Company Name</label>
                                            <input class="form-control" id="firstName1" name="cname" type="text" placeholder="Company name" required />
                                            @error('cname')
                                            <p class="invalid-feedback">{{ $message}}</p>
                                            @enderror
                                        </div>
                                        <!-- Other form fields remain unchanged -->
                                        <!-- ... -->
                                        
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="picker1">Select Project</label>
                                            <select class="form-control" name="project">
                                                <option value="">...</option>
                                                @if(isset($projectData['data']) && is_array($projectData['data']))
                                                    @foreach($projectData['data'] as $project)
                                                        @if(isset($project['pro_id']) && isset($project['project']))
                                                        <option value="{{$project['pro_id']}}">{{$project['project']}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                <option value="" disabled>No projects available</option>
                                                @endif
                                            </select>
                                            @error('project')
                                            <p class="invalid-feedback">{{ $message}}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Remaining form fields stay the same -->
                                        <!-- ... -->
                                        
                                    </div>

                                    <div class="card-title mb-3"> Project Basic Details Need for Working</div>
                                    <div class="row">
                                        <!-- Project detail fields stay the same -->
                                        <!-- ... -->
                                    </div>

                                    <div class="col-md-12">
                                        @if(isset($projectData['data'][0]['pro_id']))
                                        <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                        @else
                                        <button class="btn btn-primary" name="submit" type="submit" disabled>Submit</button>
                                        <div class="alert alert-info mt-2">
                                            <small>Submit button is disabled because no project is associated with your account. Please create a project first.</small>
                                        </div>
                                        @endif
                                        <a class="btn btn-secondary" href="{{route('user.dashboard')}}">Skip</a>
                                    </div>
                                </form>
--}}


@endsection