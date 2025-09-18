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
    <b>!Please provide your & project details first by following these steps.</b>

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
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Project</h2><small>see your projects progress >> click here</small>
                        </div>
                    </div>
                </div>
            </div></a>
        </div>

        <div class="col-md-3 col-lg-3">
            <a href="{{ route('user.payment') }}">
                <div class="card mb-4 o-hidden" data-route="user.payment">
                    <div class="card-body ul-card__widget-chart">
                        <div class="ul-widget__chart-info">
                            <div class="ul-widget__chart-number">
                                <h2 class="t-font-boldest">Billing</h2><small>see your invoices >> click here</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-lg-3">
            <a href="{{ route('user.training') }}">
                <div class="card mb-4 o-hidden" data-route="user.training">
                    <div class="card-body ul-card__widget-chart">
                        <div class="ul-widget__chart-info">
                            <div class="ul-widget__chart-number">
                                <h2 class="t-font-boldest">Training</h2><small>professional training videos >> click here</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
                
        <div class="col-md-3 col-lg-3">
            <a href="{{ route('user.complain') }}">
                <div class="card mb-4 o-hidden" data-route="user.complain">
                    <div class="card-body ul-card__widget-chart">
                        <div class="ul-widget__chart-info">
                            <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Ticket</h2><small >generate ticket in case of any delay >> click here</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
                
    <div class="row"> 
        <div class="col-lg-8 col-xl-8 mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="ul-widget__head v-margin">
                        <div class="ul-widget__head-label">
                            <h3 class="ul-widget__head-title" id="comma_decimal">Running Project Details</h3>
                        </div>
                    </div>
                    <div class="ul-widget-body">
                        <div class="ul-widget3">
                            <div class="ul-widget6__item--table">
                                <table class="table">
                                    <thead>
                                        <tr class="ul-widget6__tr--sticky-th">
                                            <th scope="col">Create Date/Time</th>
                                            <th scope="col">Project Type</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Project Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($projectData['data']) && is_array($projectData['data']) && count($projectData['data']) > 0)
                                            @php $serialNumber = 1; @endphp
                                            @foreach ($projectData['data'] as $project)
                                                <tr>
                                                    <td scope="row">
                                                        @if(isset($project['create_data']))
                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project['create_data'])->format('Y-m-d') }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>{{ $project['project'] ?? 'N/A' }}</td>
                                                    <td>{{ $project['status'] ?? 'N/A' }}</td>
                                                    <td>
                                                        <a href="{{ route('user.project.view', ['project_id' => $project['pro_id']]) }}">
                                                        <button class="btn btn-primary btn-sm custom-btn" name="submit" type="submit">View</button></a>
                                                        <a href="{{ route('user.modification', ['id' => $project['pro_id'], 'assign_user' => $project['assign_user_id'], 'com_id' => $com_id]) }}">
                                                        <button class="btn btn-info btn-sm custom-btn" name="submit" type="submit">Modification</button></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">No project data found.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xl-4 mt-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="ul-widget__head">
                        <div class="ul-widget__head-label">
                            <h3 class="ul-widget__head-title">Communication</h3>
                        </div>
                    </div>
                    <div class="ul-widget__body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="__g-widget4-tab1-content" style="background-color:white;">
                                <div class="ul-widget1">
                                    <div class="ul-widget4__item ul-widget4__users">
                                        <div class="ul-widget4__img"><img id="userDropdown" src="{{asset('templateassets/images/images.png')}}" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" /></div>
                                        <div class="ul-widget2__info ul-widget4__users-info"><a class="ul-widget2__title" href="#">Anna Strong</a><span class="ul-widget2__username" href="#">Visual Designer,Google Inc</span></div>
                                        <div class="ul-widget4__actions">
                                            <button class="btn btn-outline-danger btn-sm custom-btn m-1" type="button">View More</button>
                                        </div>
                                    </div>
                                    <div class="ul-widget4__item ul-widget4__users">
                                        <div class="ul-widget4__img"><img id="userDropdown" src="{{asset('templateassets/images/customer-service-icon.png')}}" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" /></div>
                                        <div class="ul-widget2__info ul-widget4__users-info"><a class="ul-widget2__title" href="#">Anna Strong</a><span class="ul-widget2__username" href="#">Visual Designer,Google Inc</span></div>
                                        <div class="ul-widget4__actions">
                                            <button class="btn btn-outline-success btn-sm custom-btn m-1" type="button">View More</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Recent Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="chat-container">
                        <div class="chat-messages" id="chat-messages">
                            <!-- Dummy data -->
                            <div class="message received">
                                <div class="message-content">Hello! How can I assist you today?</div>
                            </div>
                            <div class="message sent">
                                <div class="message-content">Hi there! I'm looking for some information about your products.</div>
                            </div>
                        </div>
                        <div class="chat-input">
                            <div class="input-group">
                                <input type="text" class="form-control" id="textInput" placeholder="Type your message...">
                                <div class="input-group-append">
                                    <label for="fileInput" class="input-group-text file-upload-btn">
                                        <i class="fas fa-images"></i>
                                    </label>
                                    <input type="file" class="form-control-file" id="fileInput" style="display: none;">
                                    <button class="btn btn-primary" id="sendMessageBtn">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                                <h5>
                                @if(isset($projectforms) && count($projectforms) > 0)
                                    @foreach ($projectforms as $index => $formData)
                                        @if ($index === 0 || $formData->eemail !== $projectforms[$index - 1]->eemail)
                                            <b>{{ $formData->eemail ?? 'N/A' }}</b>
                                        @endif
                                    @endforeach
                                @else
                                    <b>No data available</b>
                                @endif
                                </h5>
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
                                                        
                                                                    <?php
                                                                        $is_uploaded= 0;
                                                                    ?>
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
                if (cardTitle) cardTitle.style.color = '#ffffff'; // Change h2 text color to white
                if (cardDescription) cardDescription.style.color = '#ffffff'; // Change small text color to white
            }
        });

        // Scroll to the datatables section
        var dataTableSection = document.getElementById('comma_decimal');
        if (dataTableSection) {
            dataTableSection.scrollIntoView(); // Smooth scroll to the section
        }
    });
</script>

<script>
    // JavaScript to handle file upload
    document.getElementById("fileInput").addEventListener("change", function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const messageInput = document.getElementById("textInput");
                messageInput.value += event.target.result; // Append file content to text input
            };
            reader.readAsText(file);
        }
    });

    // JavaScript to handle sending message
    document.getElementById("sendMessageBtn").addEventListener("click", function() {
        const messageInput = document.getElementById("textInput");
        const message = messageInput.value.trim(); // Get the message from the text input
        if (message !== "") {
            // Your code to send the message
            console.log("Message sent: " + message);
            // Clear the text input after sending the message
            messageInput.value = "";
        }
    });
</script>
@endsection