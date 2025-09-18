@extends('team.layout.navbar')
@section('content')
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Team Dashboard</h1>
   
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li>Version 4</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row mb-4">
        @foreach($result as $team => $count)
        
            <div class="col-md-4 col-lg-4">
                <div class="card mb-4 o-hidden">
    
                    <div class="card-body ul-card__widget-chart">
                        <div class="ul-widget__chart-info"><h3>{{$team}}</h3>
                            <h5 class="heading">Late Replies</h5>
                            <div class="ul-widget__chart-number">
                                <h2 class="t-font-boldest">{{$count}}</h2>
                            </div>
                        </div>
                        <div id="basicArea-chart"></div>
                    </div>
                </div>
            </div>
         
        @endforeach
       
        <div class="col-md-4 col-lg-4">
            <a href="{{route('team.followup')}}">  
                <div class="card mb-4 o-hidden">
    
                    <div class="card-body ul-card__widget-chart">
                        <div class="ul-widget__chart-info"><h3>Follow Up Tasks</h3>
                            <h5 class="heading">Remaining Task</h5>
                            <div class="ul-widget__chart-number">
                                <h2 class="t-font-boldest">{{$allcount}}</h2>
                            </div>
                        </div>
                        <div id="basicArea-chart2"></div>
                    </div>
                </div>
            </a> 
        </div>
        <div class="col-md-4 col-lg-4">
            <a href="{{route('team.tickets')}}">
            <div class="card mb-4 o-hidden">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info"><h3>Total Received Tickets</h3>
                        <h5 class="heading">Tickets</h5>
                        <div class="ul-widget__chart-number">
                         <h2 class="t-font-boldest">{{$ticket}}</h2>
                        </div>
                    </div>
                    <div id="basicArea-chart4"></div>
                </div>
            </div>
            </a>
        </div>
        
    </div>
                
    <!--            <div class="col-md-4 col-lg-4 mt-4">-->
           
    <!--                            <div class="card">-->
    <!--                                <div class="card-body">-->
    <!--                                    <div class="ul-widget__head">-->
    <!--                                        <div class="ul-widget__head-label">-->
    <!--                                            <h3 class="ul-widget__head-title"><b>Announcements</b></h3>-->
    <!--                                        </div>-->
    <!--                                        <div class="ul-widget__head-toolbar">-->
    <!--                                            <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line" role="tablist">-->
    <!--                                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#__g-widget-s7-tab1-content" role="tab" aria-selected="true">Latest</a></li>-->
    <!--                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#__g-widget-s7-tab2-content" role="tab" aria-selected="false">Recent</a></li>-->
    <!--                                            </ul>-->
    <!--                                        </div>-->
    <!--                                    </div>-->
    <!--                                    <div class="ul-widget__body">-->
    <!--                                        <div class="tab-content">-->
    <!--                                            <div class="tab-pane active show" style="background-color:white" id="__g-widget-s7-tab1-content">-->
    <!--                                                <div class="ul-widget-s7n">-->
    <!--                                                    @if(count($messages) > 0)-->
    <!--                                                        <div class="ul-widget-s7__items mb-4"><span class="ul-widget-s7__item-time ul-middle" style="font-size:13px;">{{ $messages->last()->created_at->format('Y-m-d') }}</span>-->
    <!--                                                        <div class="ul-widget-s7__item-circle">-->
    <!--                                                            <p class="ul-vertical-line bg-primary"></p>-->
    <!--                                                        </div>-->
    <!--                                                        <div class="ul-widget-s7__item-text text-danger">-->
    <!--                                                           {{ $messages->last()->message }}-->
    <!--                                                        </div>-->
    <!--                                                    </div>-->
    <!--                                                    @else-->
    <!--                                                        <p>No messages found.</p>-->
    <!--                                                    @endif     -->
                                                     
    <!--                                                </div>-->
    <!--                                            </div>-->
    <!--                                            <div class="tab-pane" id="__g-widget-s7-tab2-content" style="background-color:white">-->
    <!--                                                <div class="ul-widget-s7n">-->
    <!--                                                    @if(count($messages) > 0)-->
            
    <!--                                                        @foreach($messages->reverse() as $message)  -->
    <!--                                                            <div class="ul-widget-s7__items mb-4"><span class="ul-widget-s7__item-time ul-middle" style="font-size:13px;">{{ $message->created_at->format('Y-m-d') }}</span>-->
    <!--                                                            <div class="ul-widget-s7__item-circle">-->
    <!--                                                                <p class="ul-vertical-line bg-danger"></p>-->
    <!--                                                            </div>-->
    <!--                                                            <div class="ul-widget-s7__item-text">-->
    <!--                                                               {{ $message->message }}-->
    <!--                                                            </div>-->
    <!--                                                        </div>-->
    <!--                                                        @endforeach-->
            
    <!--                                                    @else-->
    <!--                                                        <p>No messages found.</p>-->
    <!--                                                    @endif-->
                                                      
                                                      
    <!--                                                </div>-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                    </div>-->
    <!--                                </div>-->
    <!--                            </div>-->
                            
       
        
       
        <!-- finance-->
    <!--    <div class="col-md-12 col-lg-12 mt-4">-->
    <!--    </div>-->
    
    
    <!--</div>-->

    <div class="row mb-4">
        <div class="col-md-12 col-lg-12 mb-4">

            @if(session('success'))
                <div id="flash-message" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card text-left">
                <div class="card-body">
                    <h2>Late Replies Details</h2>
                        <div>
                            <div class="table-responsive">
        
                            <table class="display table table-striped table-bordered" id="comma_decimal_table" style="width:100%">
                               
                                <thead>
                                    <div class="row">
                                        <div class="col-2">
                                             <form id="dateFilterForm">
                                                 <b>Filter By date</b>
                                                <input type="text" class="form-control mb-2" id="fromDate" placeholder="From Date">
                                                <input type="text" class="form-control mb-3"id="toDate" placeholder="To Date">
                                            </form>
                                        </div>
                                    </div>
                                   
                                    <tr>
                                        <th>Id</th>
                                        <th>Date</th>
                                         <th>Time</th>
                                        <th>TeamMember</th>
                                        <th>User</th>
                                        <th>User Message</th>
                                        <th>LateTime</th>
                                        <th>Send Reason</th>
                                    </tr>
                                </thead>
                                <tbody id="messages-list">
                                    
        
    
                                    @foreach ($responseb as $lateMessage)
                                        @php
                                            // Parse the created_at timestamp
                                            $createdAt = new DateTime($lateMessage->created_at);
                                    
                                            // Separate date and time
                                            $date = $createdAt->format('Y-m-d'); // e.g., "2024-12-02"
                                            $time = $createdAt->format('H:i:s'); // e.g., "14:30:00"
                                        @endphp
                                        <tr><td>{{ $lateMessage->id }}</td>
                                        <td>{{ $date }}</td>
                                        <td>{{ $time }}</td>
                                        <td>{{ $lateMessage->teammember }}</td>
                                        <td>{{ $lateMessage->user }}</td>
                                        <td>{{ $lateMessage->message }}</td>
           
                                        @php
                                            $minutes = $lateMessage->lateminutes;
                                        @endphp
    
                                        <td>
                                            
                                                {{ $lateMessage->lateminutes }} 
                                        </td>
    
                        
                                        <td>
                                            <form method="POST" action="{{ route('team.reason', ['id' => $lateMessage->id]) }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="PUT">
                                                
                                                <input type="text" name="reason" class="form-control mb-2" placeholder="Reason" required>
                                                
                                                @if(in_array($lateMessage->id, $submittedMessageIds))
                                                    <button class="btn btn-primary submit-button" data-message-id="{{ $lateMessage->id }}" type="button" disabled>
                                                        Submit
                                                    </button>
                                                @else
                                                    <button class="btn btn-primary submit-button" data-message-id="{{ $lateMessage->id }}" type="submit">
                                                        Submit
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
    
    
                                        </tr>
                                      
                                    @endforeach
                                      

                                </tbody>
                                <tfoot>
                                    <tr>
                                     <th>Id</th>
                                        <th>Date</th>
                                         <th>Time</th>
                                        <th>TeamMember</th>
                                        <th>User</th>
                                        <th>User Message</th>
                                        <th>LateMinutes</th>
                                        <th>Send Reason</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>
<script>
    // Attach click event listener to submit buttons
    document.querySelectorAll('.submit-button').forEach(function(button) {
        var messageId = button.getAttribute('data-message-id');

        // If the message is not already submitted, attach the click event listener
        if (!button.disabled) {
            button.addEventListener('click', function() {
                // Get the button's parent row
                var row = button.closest('tr');

                // Find the input element within the row
                var reasonInput = row.querySelector('.form-control');

                // Make an AJAX request to submit the data
                $.ajax({
                    type: 'POST',  // Sending as POST
                    url: '{{ route("team.reason", ":id") }}'.replace(':id', messageId),  // Use message ID in the URL
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',  // Override method to PUT
                        reason: reasonInput.value,  // The reason input value
                    },
                    success: function(response) {
                        // Display success message (assuming the response contains a success message)
                        $('#flash-message').html(response.success).show();

                        // Clear input value
                        reasonInput.value = '';

                        // Disable the button after successful submission
                        button.disabled = true;

                        // Optionally, update the UI to indicate the reason was updated
                        // For example, you can update a part of the row or show a checkmark
                    },
                    error: function(xhr, status, error) {
                        // Optionally, handle errors
                        console.error('Error:', error);
                    }
                });
            });
        }
    });
</script>





@endsection
