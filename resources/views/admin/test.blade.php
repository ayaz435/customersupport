@extends('admin.layout.navbar')
@section('content')
<style>
    .select2-selection.select2-selection--single {
        height: 35px !important;
        padding-top: 4px !important;
    }
</style>
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Running Project Details</h1>

        </div>
        <form method="POST" action="{{ route('projectform.submit') }}">
            @csrf
            <div class="row align-items-end">
                <div class="col-md-4 form-group mb-3">
                    <label for="picker1">Select Related Category</label>
                    <select class="form-control select2" name="email">
                        <option value="">Select Email</option>
                        @foreach($eemails as $eemail)
                            <option value="{{ $eemail->email }}">{{ $eemail->email }} ({{ $eemail->name }})</option>
                        @endforeach
                    </select>
                    @error('email')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-auto form-group mb-3">
                    <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                </div>
            </div>
        </form>

        <!-- end of row-->
        <section class="widgets-content">
            <div>
                <!-- begin::first-section-->
                <div class="row mt-2">
                    <div class="col-lg-12 col-md-12 col-xl-12 mt-2 mb-2">
                        <!-- start::widget tasks-->
                        <div class="card">
                            <div class="card-body">
                              <center></center>
                                <div class="ul-widget__head ">

                                    <div class="ul-widget__head-label">
                                        @foreach ($projectforms as $index => $formData)
                                            @if ($index === 0 || $formData->eemail !== $projectforms[$index - 1]->eemail)
                                                <h4><b>{{ $formData->user->name }}</b></h4>
                                                <h5 class="text-muted">{{ $formData->eemail }}</h5>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="ul-widget__head-toolbar">
                                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line ul-widget-nav-tabs-line"
                                            role="tablist">
                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                    href="#ul-widget2-tab1-content" role="tab">Customer Data</a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                    href="#ul-widget2-tab2-content" role="tab">Product Catagories</a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                    href="#ul-widget2-tab3-content" role="tab">Project Data Files</a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                    href="#ul-widget2-tab4-content" role="tab">Minisite Design</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <br>

                                <div class="ul-widget__body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" style="background-color:white;" id="ul-widget2-tab1-content">
                                            @if(isset($projectforms) && count($projectforms) > 0)
                                                @foreach ($projectforms as $formData)
                                                    <div class="ul-widget1">
                                                        <b class="text-danger">Date:</b>
                                                        <b class="text-danger">{{ $formData->created_at ? $formData->created_at->format('d-m-Y') : 'N/A' }}</b>
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Company Name:</b>
                                                        {{ $formData->cname ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Contact Person Name:</b>
                                                        {{ $formData->cpname ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Partner:</b>
                                                        {{ $formData->ppname ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>NIC:</b>
                                                        {{ $formData->nic ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>NTN:</b>
                                                        {{ $formData->ntn ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Email:</b>
                                                        {{ $formData->email ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Website:</b>
                                                        {{ $formData->web ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Phone:</b>
                                                        {{ $formData->phone ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Mobile:</b>
                                                        {{ $formData->mobile ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Address:</b>
                                                        {{ $formData->address ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Catagory:</b>
                                                        {{ $formData->catagory ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Company Profile:</b>
                                                        {{ $formData->cpabout ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>refrence Website:</b>
                                                        {{ $formData->rwebsite ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Colors:</b>
                                                        {{ $formData->color ?? 'N/A' }}
                                                    </div>
                                                    <div class="ul-widget1">
                                                        <b>Your Website:</b>
                                                        {{ $formData->ywebsite ?? 'N/A' }}
                                                        <hr>
                                                    </div>
                                                    <br>
                                                @endforeach
                                            @else
                                                <div class="ul-widget1">
                                                    <p>No customer data available.</p>
                                                </div>
                                            @endif
                                        </div>
                                                    
                                        <div class="tab-pane" style="background-color:white;" id="ul-widget2-tab2-content">
                                            @php
                                                $prevDate = null;
                                            @endphp
        
                                            @if(isset($categories) && count($categories) > 0)
                                                <div class="container">
                                                <h2 class="mb-4">Categories List</h2>
                                            
                                                @foreach ($categories as $category)
                                                    <div class="card mb-4">
                                                        <div class="card-header bg-primary text-white">
                                                            <h4>{{ $category->name }}</h4>
                                                        </div>
                                            
                                                        <div class="card-body">
                                                            @if ($category->subCategories->count())
                                                                <ul class="list-group">
                                                                    
                                                                    @foreach ($category->subCategories as $sub)
                                                                        <li class="list-group-item">
                                                                            <strong>Subcategory:</strong> {{ $sub->name }}
                                                                            
                                                                            @php
                                                                                $is_uploaded= 0;
                                                                            @endphp
                                                                            @if ($sub->productDesigns->count())
                                                                                <ul class="mt-2">
                                                                                    <strong> Selected Products:</strong> <br>
                                                                                    @foreach ($sub->productDesigns as $design)
                                                                                        @if(!$is_uploaded && $design->is_uploaded)
                                                                                            <br><strong> Uploaded Products:</strong> <br>
                                                                                            @php
                                                                                                $is_uploaded= 1;
                                                                                            @endphp
                                                                                        @endif
                                                                                        <li>
                                                                                            <small>Url: {{ $design->images }}</small>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @else
                                                                                <p class="text-muted mt-2">No matching product designs.</p>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <p class="text-muted">No subcategories found.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @else
                                                <div class="ul-widget1">
                                                    <p>No category data available.</p>
                                                </div>
                                            @endif
                                        </div>
                                                              
                                        <div class="tab-pane" style="background-color:white;" id="ul-widget2-tab3-content">
                                            @if(isset($files) && count($files) > 0)
                                                @foreach ($files as $file)
                                                    <div class="ul-widget1">
                                                        <div class="ul-widget2__item">
                                                            <div>
                                                                <span>{{ $file->file ?? 'No file name' }}</span>
                                                                @if(isset($file->file))
                                                                    <a href="{{ route('file.download', ['file' => $file->file]) }}"><button class="mx-4 btn btn-primary">Download</button></a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="ul-widget1">
                                                    <p>No files available.</p>
                                                </div>
                                            @endif
                                        </div>
                                               
                                        <div class="tab-pane" style="background-color:white;" id="ul-widget2-tab4-content">
                                            @if(isset($mini_site_design) && count($mini_site_design) > 0)
                                                @foreach ($mini_site_design as $design)
                                                    <div class="ul-widget1">
                                                        <div class="ul-widget2__item">
                                                            <div>
                                                                <span>{{ $design->design_name  }} : {{ $design->main_img }}</span>
                                                                {{--
                                                                @if(isset($design->main_img))
                                                                     <img src="{{ $design->main_img }}" alt="Design Image" class="img-fluid mt-2" style="max-height: 200px;"> 
                                                                @endif
                                                                --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="ul-widget1">
                                                    <p>No minisite designs available.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end::widget tasks-->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
