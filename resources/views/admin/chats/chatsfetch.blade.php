@extends('admin.layout.navbar')
@section('content')
<div class="main-content">
    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="breadcrumb">
        <h1>Team/Users Chats</h1>
    </div>
    <div id="toastr-notifications" style="position: fixed; top: 0; right: 0; margin: 15px; z-index: 9999;">   <ul id="lateTeamMessagesList">
                        <!-- Existing messages will be displayed here -->
                    </ul></div>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
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
                                        <th>LateMinutes</th>
                                        <th>Reason from Teammember</th>
                                    </tr>
                                </thead>
                                <tbody id="messages-list">

                                @foreach ($response as $lateMessage)
    @php
        // Parse the created_at timestamp
        $createdAt = new DateTime($lateMessage->created_at);

        // Separate date and time
        $date = $createdAt->format('Y-m-d'); // e.g., "2024-12-02"
        $time = $createdAt->format('H:i:s'); // e.g., "14:30:00"
    @endphp
    <tr>
        <td>{{ $lateMessage->id }}</td>
        <td>{{ $date }}</td>
        <td>{{ $time }}</td>
        <td>{{ $lateMessage->teammember }}</td>
        <td>{{ $lateMessage->user }}</td>
        <td>{{ $lateMessage->message }}</td>
        <td>{{ $lateMessage->lateminutes }}</td>
        <td>@if(isset($lateMessage->reason)){{ $lateMessage->reason }}@endif</td>
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
                                        <th>Reason from Teammember</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Include Toastr CSS and JS -->
<h2>Team Members Late Replies Details</h2>

<table class="table table-striped table-bordered text-center">
    <thead>
        <tr>
            <th>Name</th>
            <th>Total Late Replies</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result as $team )
        <tr>
            <td>{{$team->name}}</td>
            <td>{{$team->late_messages_count}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
