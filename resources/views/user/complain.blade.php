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
 .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
  }

  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    position: relative;
  }

  .close {
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 24px;
    cursor: pointer;
  }

  .review-section {
    display: none;
  }

  .review-section.active {
    display: block;
  }

  .star-rating {
    font-size: 30px;
  }

  .star {
    cursor: pointer;
    color: gray;
  }

  .star.selected {
    color: gold;
  }

.star-rating input[type="radio"] {
  display: none; /* hide the actual radio buttons */
}

.star-rating label {
  font-size: 30px; /* adjust the size of the stars */
  color: #ccc; /* default color of the stars */
  cursor: pointer;
}

.star-rating label:hover,
.star-rating input[type="radio"]:checked + label {
  color: #ffcc00; /* color of the selected stars */
}

.star-rating input[type="radio"],
.star-rating label {
  position: relative;
  z-index: 0;
}

.fscard
{
font-size:12px;
}
/* Show the span when its corresponding input/label is hovered or focused */

 #message {
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px;
        color: white;
        font-weight: bold;
    }

    .success {
        background-color: #f44336; /* Green */
    }

    .error {
        background-color: #4CAF50; /* Red */
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
       

 <div class="col-md-12 mb-4"><div class="breadcrumb mt-3" id="comma_decimal">
        <h1>  Your Ticket details</h1>

    </div>
            <div class="card text-left" >
                <div class="card-body">
                    <h4 class="card-title mb-3"></h4>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="comma_decimal_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Create_date</th>
                                    <th>TicketNo</th>
                                    <th>Priority</th>
                                    <th>Description</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>@php $serialNumber = 1; @endphp
                                @foreach  ($complains as $complain )
                                <tr>
                                    <td>{{ date('Y-m-d', strtotime($complain['create_date'])) }} </td>
                                    <td>{{ $complain['id']}}</td>
                                    <td>{{ $complain['priority']}}</td>
                                    <td>{{ $complain['description']}}</td>
                                    <td>{{ $complain['status']}}</td>
                                    <td>
                                        @if($complain->reviews && $complain->reviews->count() > 0)
                                            {{-- Review already submitted --}}
                                            <span class="badge bg-success">Reviewed</span>
                                        @else
                                            {{-- Show button to open modal --}}
                                            <button class="btn btn-primary openModalBtn" 
                                                    data-id="{{ $complain->id }}">
                                                Confirmation
                                            </button>
                                        @endif
                                    </td>                                
                                </tr>
                            <div id="myModal{{ $complain['id'] }}"  class="modal">
                                <!-- Modal content -->
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <form id="reviewForm{{ $complain['id'] }}">
                                        <div class="review-section active" style="background-color:white">
                                            <h2>Client-Review</h2>
                                            <p>How would you rate our services?</p>
                                    
                                            <div class="star-rating">
                                                <h3>Manager Service</h3>
                                                <div class="row" style="line-height: 0.3;">
                                                    <div class="col-5">
                                                        <b><span class="mx-2 mr-3 fscard">1</span><span class="mx-2 mr-3 fscard">2</span><span class="mx-2 mr-2 fscard">3</span><span class="mx-3 fscard">4</span><span class="mx-3 fscard">5</span></b>
                                                    </div>
                                                </div>
                                                <input type="radio" id="manager-star1{{ $complain['id'] }}" name="manager-rating{{ $complain['id'] }}" value="1">
                                                <label for="manager-star1{{ $complain['id'] }}">&#9733;</label>
                                            
                                                <input type="radio" id="manager-star2{{ $complain['id'] }}" name="manager-rating{{ $complain['id'] }}" value="2">
                                                <label for="manager-star2{{ $complain['id'] }}">&#9733;</label>
                                                
                                                <input type="radio" id="manager-star3{{ $complain['id'] }}" name="manager-rating{{ $complain['id'] }}" value="3">
                                                <label for="manager-star3{{ $complain['id'] }}">&#9733;</label>
                                            
                                                <input type="radio" id="manager-star4{{ $complain['id'] }}" name="manager-rating{{ $complain['id'] }}" value="4">
                                                <label for="manager-star4{{ $complain['id'] }}">&#9733;</label>
                                            
                                                <input type="radio" id="manager-star5{{ $complain['id'] }}" name="manager-rating{{ $complain['id'] }}" value="5">
                                                <label for="manager-star5{{ $complain['id'] }}">&#9733;</label>
                                                <!-- <textarea  name="managerdetail" id="managerdetail" placeholder="Write your feedback for Manager Service"></textarea> -->
                                            
                                                <h3>Project Development</h3>
                                                            
                                                <div class="row" style="line-height: 0.3;">
                                                    <div class="col-5">
                                                        <b><span class="mx-2 mr-3 fscard">1</span><span class="mx-2 mr-3 fscard">2</span><span class="mx-2 mr-2 fscard">3</span><span class="mx-3 fscard">4</span><span class="mx-3 fscard">5</span></b>
                                                    </div>
                                                </div>
                                                <input type="radio" id="team-star1{{ $complain['id'] }}" name="team-rating{{ $complain['id'] }}" value="1">
                                                <label for="team-star1{{ $complain['id'] }}">&#9733;</label>
                                            
                                                <input type="radio" id="team-star2{{ $complain['id'] }}" name="team-rating{{ $complain['id'] }}" value="2">
                                                <label for="team-star2{{ $complain['id'] }}">&#9733;</label>
                                            
                                                <input type="radio" id="team-star3{{ $complain['id'] }}" name="team-rating{{ $complain['id'] }}" value="3">
                                                <label for="team-star3{{ $complain['id'] }}">&#9733;</label>
                                                
                                                <input type="radio" id="team-star4{{ $complain['id'] }}" name="team-rating{{ $complain['id'] }}" value="4">
                                                <label for="team-star4{{ $complain['id'] }}">&#9733;</label>
                                            
                                                <input type="radio" id="team-star5{{ $complain['id'] }}" name="team-rating{{ $complain['id'] }}" value="5">
                                                <label for="team-star5{{ $complain['id'] }}">&#9733;</label>
                                                <!-- <textarea name="projectdetail" placeholder="Write your feedback for Manager Service"></textarea> -->
                                                <h3>Overall Satisfaction</h3>
                                                        
                                                <div class="row" style="line-height: 0.3;">
                                                    <div class="col-5">
                                                        <b><span class="mx-2 mr-3 fscard">1</span><span class="mx-2 mr-3 fscard">2</span><span class="mx-2 mr-2 fscard">3</span><span class="mx-3 fscard">4</span><span class="mx-3 fscard">5</span></b>
                                                    </div>
                                                </div>
                                                <input type="radio" id="overall-star1{{ $complain['id'] }}" name="overall-rating{{ $complain['id'] }}" value="1">
                                                <label for="overall-star1{{ $complain['id'] }}">&#9733;</label>
                                            
                                                <input type="radio" id="overall-star2{{ $complain['id'] }}" name="overall-rating{{ $complain['id'] }}" value="2">
                                                <label for="overall-star2{{ $complain['id'] }}">&#9733;</label>
                                                
                                                <input type="radio" id="overall-star3{{ $complain['id'] }}" name="overall-rating{{ $complain['id'] }}" value="3">
                                                <label for="overall-star3{{ $complain['id'] }}">&#9733;</label>
                                                
                                                <input type="radio" id="overall-star4{{ $complain['id'] }}" name="overall-rating{{ $complain['id'] }}" value="4">
                                                <label for="overall-star4{{ $complain['id'] }}">&#9733;</label>
                                                
                                                <input type="radio" id="overall-star5{{ $complain['id'] }}" name="overall-rating{{ $complain['id'] }}" value="5">
                                                <label for="overall-star5{{ $complain['id'] }}">&#9733;</label>
                                                <!--  <textarea name="overalldetail" placeholder="Write your feedback for Manager Service"></textarea> -->
                                            </div>
                                            <!-- <textarea name="suggestion" placeholder="Write your suggestions"></textarea> -->
                                            <textarea type="text" id="suggestion{{ $complain['id'] }}" name="suggestion"> </textarea>
                                            <button type="button" onclick="setFeedBack({{ $complain['id'] }})" class="btn btn-primary next-btn">Submit</button>
                                        </div>
                                        <div class="thanks-section" style="display: none;">
                                            <h2>Thanks for your review!</h2>
                                        </div>
                                    </form>
                                </div>

                                @endforeach

                            </tbody>
                           
                        </table>
                    </div>
                </div>
            </div>

                            
                            
    <div class="breadcrumb mt-5">
        <h1> Send Your Ticket to us</h1>

    </div>
    
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div id="message"></div>
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
                                    <div class="card-title mb-3">Fill This Form </div>
                                   
                                        <!--id="postForm"-->   
                                        <form  method="GET" action="{{ route('user.createticket') }}">
                                            @csrf
                                            <input type="hidden" name="form_identifier" value="form1">
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="priority">Priority</label>
                                                    <select id="priority" class="form-control" name="priority">
                                                        <option>...</option>
                                                        <option value="Low">Low</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="High">High</option>
                                                    </select>
                                                    @error('priority')
                                                        <p class="invalid-feedback">{{ $message}}</p>
                                                    @enderror
                                                </div>    
                                                
                                         
                                                <input id="com_id" class="form-control" name="com_id" type="hidden" placeholder="Enter your Company Id" value='{{ $comId }}' readonly />
                                                @error('com_id')
                                                    <p class="invalid-feedback">{{ $message}}</p>
                                                @enderror
                                        
                                                <div class="col-md-6 form-group mb-3">
                                                    <label for="ticketpurpose">Ticket Against</label>
                                                    <select onchange="toggleFields()" id="ticketpurpose" class="form-control" name="ticketpurpose">
                                                        <option value="">...</option>
                                                        <option value="About Services">About Services</option>
                                                        <option value="About Team Member">About Team Member</option>
                                                    </select>
                                                    <input id="dep_id" class="form-control" name="dep_id" type="hidden" value="" />
                                                    @error('service')
                                                        <p class="invalid-feedback">{{ $message}}</p>
                                                    @enderror
                                                </div>
                                                <select id="service" class="form-control" name="service" style="display: none;">
                                                    <option value="0" dep_id="0">...</option>
                                                </select>
                                                <!-- Dynamic field that changes based on selection -->
                                                <div class="col-md-6 form-group mb-3" id="dynamicField" style="display: none;">
                                                    <label for="dynamicSelect" id="dynamicLabel">Select Option</label>
                                                    <select class="form-control" id="dynamicSelect" name="dynamic_selection">
                                                        <option value="">...</option>
                                                    </select>
                                                    @error('user_id')
                                                        <p class="invalid-feedback">{{ $message}}</p>
                                                    @enderror
                                                    @error('service_id')
                                                        <p class="invalid-feedback">{{ $message}}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div class="col-md-12 form-group mb-3">
                                                    <label for="detail">Ticket Description</label>
                                                    <textarea class="form-control" name="detail" id="detail" type="text" placeholder="Enter ticket description"></textarea>
                                                    @error('detail')
                                                        <p class="invalid-feedback">{{ $message}}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                        
                                        <!-- Pass server data to JavaScript -->
                                        <script>
                                            // Get data from server (add this in your Blade template)
                                            const serviceNames = @json($serviceNames ?? []);
                                            const teamNames = @json($teamNames ?? []);
                                            
                                            function toggleFields() {
                                                const serviceSelect = document.getElementById('ticketpurpose');
                                                const dynamicField = document.getElementById('dynamicField');
                                                const dynamicLabel = document.getElementById('dynamicLabel');
                                                const dynamicSelect = document.getElementById('dynamicSelect');
                                                const depIdInput = document.getElementById('dep_id');
                                                
                                                // Clear previous options
                                                dynamicSelect.innerHTML = '<option value="">...</option>';
                                                
                                                if (serviceSelect.value === 'About Services') {
                                                    // Show field for services
                                                    dynamicField.style.display = 'block';
                                                    dynamicLabel.textContent = 'Services';
                                                    dynamicSelect.name = 'service_id';
                                                    
                                                    // Add service options
                                                    serviceNames.forEach(function(service) {
                                                        const option = document.createElement('option');
                                                        option.value = service.id;
                                                        option.setAttribute('data-dep-id', service.dep_id);
                                                        option.textContent = service.name;
                                                        dynamicSelect.appendChild(option);
                                                    });
                                                    
                                                    // Handle department ID when service is selected
                                                    dynamicSelect.addEventListener('change', function() {
                                                        const selectedOption = this.options[this.selectedIndex];
                                                        if (selectedOption.hasAttribute('data-dep-id')) {
                                                            depIdInput.value = selectedOption.getAttribute('data-dep-id');
                                                        } else {
                                                            depIdInput.value = '';
                                                        }
                                                    });
                                                    
                                                } else if (serviceSelect.value === 'About Team Member') {
                                                    // Show field for team members
                                                    dynamicField.style.display = 'block';
                                                    dynamicLabel.textContent = 'Team Member';
                                                    dynamicSelect.name = 'team_id';
                                                    
                                                    // Add team member options
                                                    teamNames.forEach(function(team) {
                                                        const option = document.createElement('option');
                                                        option.value = team.id;
                                                        option.textContent = team.name;
                                                        dynamicSelect.appendChild(option);
                                                    });
                                                    
                                                    
                                                    // Clear department ID for team member selection
                                                    depIdInput.value = '';
                                                    
                                                } else {
                                                    // Hide field if no valid selection
                                                    dynamicField.style.display = 'none';
                                                    dynamicSelect.name = 'dynamic_selection';
                                                    depIdInput.value = '';
                                                }
                                            }
                                        </script>
                                        
                                        
                                        
                                        
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
    function fun() {
        var attribute = $("#service").find(':selected').attr('dep_id');
        $("#dep_id").val(attribute);
    }

    document.getElementById("postForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get form data
        var formData = new FormData(this);
        
        

        // Send POST request to the API endpoint
        fetch('https://webexcels.pk/api/insert_api_data.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log the response from the API

                // Display message based on API response
                if (data.success) {
                    document.getElementById("message").innerText = "An error occurred while submitting the form.";
                } else {
                    document.getElementById("message").innerText = "Error: " + data.error_message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
             var messageElement = document.getElementById("message");
                messageElement.innerText = "Ticket submitted successfully!";
                messageElement.className = "error";
             
            }); // Log any errors
    });
</script>
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

<script>
    $(document).ready(function() {
        // Simulate star selection for each section
        $('.review-section').each(function() {
            var section = $(this);
            var managerRating = section.find('input[name="manager-rating"]:checked').val();
            var teamRating = section.find('input[name="team-rating"]:checked').val();
            var overallRating = section.find('input[name="overall-rating"]:checked').val();
    
            
            section.find('.star').removeClass('selected'); // Clear previously selected stars
            
            // Add 'selected' class to stars based on ratings
            section.find('.star[data-value="' + managerRating + '"]').addClass('selected');
            section.find('.star[data-value="' + teamRating + '"]').addClass('selected');
            section.find('.star[data-value="' + overallRating + '"]').addClass('selected');
        
        });
    
        // Open modal
        $('.openModalBtn').click(function() {
            var complainId = $(this).data('id');
            $('#myModal' + complainId).css('display', 'block');
            $('#myModal' + complainId + ' form').trigger('reset');
        });

        // Close modal when the close button is clicked
        $('.close').click(function() {
            $('.modal').css('display', 'none');
        });

        // Close modal when clicking outside of it
        $(window).click(function(event) {
            if (event.target.classList.contains('modal')) {
                $('.modal').css('display', 'none');
            }
        });

        // Star rating functionality
        $('.star').click(function() {
            var value = parseInt($(this).data('value'));
            var section = $(this).closest('.review-section');
            var inputName = section.find('.star-rating input[type="radio"]').attr('name');
            section.find('input[name="' + inputName + '"]').prop('checked', false);
            section.find('input[value="' + value + '"]').prop('checked', true);

            $(this).addClass('selected');
            $(this).prevAll('.star').addClass('selected');
            $(this).nextAll('.star').removeClass('selected');
        toggleTextarea(section, value);
        });
    });
    function setFeedBack(id){
        var suggestion = $('#suggestion'+id).val();
        var managerrating = $('input[name="manager-rating' + id + '"]:checked').val();
        var teamrating = $('input[name="team-rating' + id + '"]:checked').val();
        var overallrating = $('input[name="overall-rating' + id + '"]:checked').val();

        var formData = {
            complainid: id,
            'manager_rating': managerrating,
            'team_rating': teamrating,
            'overall_rating': overallrating,
            'suggestion': suggestion
        };
        
        console.log("Form Data:", formData); 
            
        $.ajax({
            url: '{{ route("reviews.store") }}', 
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                let modal = $('#myModal' + id);
                modal.find('.review-section').hide();
                modal.find('.thanks-section').show();
            },
            error: function(xhr, status, error) {
            $('.modal').css('display', 'none');
            console.error(error);
            }
        });

    }
</script>


@endsection
