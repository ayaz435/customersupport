@extends('admin.layout.navbar')
@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Running Project Details</h1>

        </div>
        <form method="POST" action="{{ route('projectform.submit') }}">
            @csrf
            <div class="row">
                <div class="col-md-3 form-group mb-3">
                    <label for="picker1">Select Related Catagory</label>
                    <select class="form-control" name="email">
                        <option value="">Select Email</option>
                         @php
        $uniqueEmails = $eemails->toArray();
        $uniqueEmails = array_unique($uniqueEmails);
    @endphp
    @foreach($uniqueEmails as $eemail)
        <option value="{{ $eemail }}">{{ $eemail }}</option>
    @endforeach
                    </select>
                    @error('email')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-1 form-group mt-4">
                    <button class="btn btn-primary" name="submit" type="Search">Submit</button>
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

                                    <div class="ul-widget__head-label"><h5>@foreach ($projectforms as $index => $formData)
    @if ($index === 0 || $formData->eemail !== $projectforms[$index - 1]->eemail)
        <b>{{ $formData->eemail }}</b>
    @endif
@endforeach</h5>
                                        <h3 class="ul-widget__head-title">Clients Data</h3>
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
                                        </ul>
                                    </div>
                                </div>
                                <br>

                                <div class="ul-widget__body">
                                    <div class="tab-content">


                                        <div class="tab-pane active" id="ul-widget2-tab1-content">
                        @foreach ($projectforms as $formData)
                        <div class="ul-widget1">
                                                <b class="text-danger">Date:</b>
                                                
                                                    <b class="text-danger">{{ $formData->created_at->format('d-m-Y') }}</b>
                                                
                                            </div>
                                            <div class="ul-widget1">
                                                <b>Company Name:</b>
                                                
                                                    {{ $formData->cname }}
                                                
                                            </div>
                                            <div class="ul-widget1">
                                                <b>Contact Person Name:</b>
                                               
                                                    {{ $formData->cpname }}
                                              
                                            </div>
                                            <div class="ul-widget1">
                                                <b>Partner:</b>
                                               
                                                    {{ $formData->ppname }}
                                            
                                            </div>
                                            <div class="ul-widget1">
                                                <b>NIC:</b>
                                               
                                                    {{ $formData->nic }}
                                               
                                            </div>
                                            <div class="ul-widget1">
                                                <b>NTN:</b>
                                                
                                                    {{ $formData->ntn }}
                                     
                                            </div>
                                            {{--  <div class="ul-widget1">
                                                <b>Company Name:</b>
                                                
                                                    {{ $formData->ctpname }}
                                             
                                            </div>  --}}
                                            <div class="ul-widget1">
                                                <b>Email:</b>
                                             
                                                    {{ $formData->email }}
                                                
                                            </div>
                                            <div class="ul-widget1">
                                                <b>Website:</b>
                                            
                                                    {{ $formData->web }}
                                              
                                            </div>
                                            <div class="ul-widget1">
                                                <b>Phone:</b>
                                                
                                                    {{ $formData->phone }}
                                                
                                            </div>
                                            <div class="ul-widget1">
                                                <b>Mobile:</b>
                                                
                                                    {{ $formData->mobile }}
                                              
                                            </div>
                                            <div class="ul-widget1">
                                                <b>Address:</b>
                                                
                                                    {{ $formData->address }}
                                             
                                            </div>
                                            <div class="ul-widget1">
                                                <b>Catagory:</b>
                                                
                                                    {{ $formData->catagory }}
                                                
                                            </div>
                                            <div class="ul-widget1">
                                                <b>Company Profile:</b>
                                                
                                                    {{ $formData->cpabout }}
                                                
                                            </div>
                                            <div class="ul-widget1">
                                                <b>refrence Website:</b>
                                                
                                                    {{ $formData->rwebsite }}
                                                
                                            </div>
                                            <div class="ul-widget1">
                                                <b>Colors:</b>
                                                
                                                    {{ $formData->color }}
                                                
                                            </div>
                                            <div class="ul-widget1">
                                                <b>Your Website:</b>
                                                
                                                    {{ $formData->ywebsite }}
                                               
  <hr>                                          </div>
<br>

 @endforeach 
                                        </div>
                                            
                                            
                                        <div class="tab-pane" id="ul-widget2-tab2-content">
                                        @php
    $prevDate = null;
@endphp

@foreach ($catagories as $catagory)
    @if (!$prevDate || $catagory->created_at->format('d-m-Y') !== $prevDate)
        <div class="date-heading">
            <b class="text-danger">Date: {{ $catagory->created_at->format('d-m-Y') }}</b>
        </div>
        @php
            $prevDate = $catagory->created_at->format('d-m-Y');
        @endphp
    @endif

    <div class="ul-widget1">
        <div class="ul-widget2__info">
            <span><b>Catagory:</b> {{$catagory->catagory }}</span>
            <span style="border-bottom: 1px solid #b1b1b1;"><b>SubCatagories:</b> {{$catagory->subcatagory }}</span>
        </div>
    </div>
@endforeach


                                        </div>
                                                     
                                                      
                                                      
                                        <div class="tab-pane" id="ul-widget2-tab3-content">
                                                      @foreach ($files as $file)
                                            <div class="ul-widget1">
                                                <div class="ul-widget2__item">

                                                   
                                                    <div>
                                                      
                                                        
                                                        <span>{{ $file->file }}</span>
                                                        <a href="{{ route('file.download', ['file' => $file->file]) }}"><button class="mx-4 btn btn-primary">Download</button></a>
                                                    </div>
                                               
                                                </div>
                                       @endforeach      </div>

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
