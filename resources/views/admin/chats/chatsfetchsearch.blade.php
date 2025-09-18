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
                                    <tr>
                                        <th>Date/Time</th>
                                        <th>TeamMember</th>
                                        <th>User</th>
                                        <th>User Message</th>
                                        <th>LateMinutes</th>
                                    </tr>
                                </thead>
                                <tbody id="messages-list">

 @foreach ($lateMessages as $lateMessage)

                                    <tr>
                                        <td>{{ $lateMessage['time'] }}</td>
                                        
                                        <td>{{ $lateMessage['to_user'] }}</td>
                                        <td>{{ $lateMessage['from_user'] }}</td>
                                        <td>{{ $lateMessage['message'] }}</td>
                                        <td>{{ $lateMessage['late_reply_minutes'] }}</td>

                                    </tr>
                                    @endforeach
                                  

                                </tbody>
                                <tfoot>
                                    <tr>
                                       <th>Date/Time</th>
                                        <th>TeamMember</th>
                                        <th>User</th>
                                        <th>User Message</th>
                                        <th>LateMinutes</th>
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

<di<div class="row mt-5">

   
    <ul>
        @foreach($toUserLateRepliesCount as $toUserName => $lateRepliesCount)
            <li><b>{{ $toUserName }}</b> - Late Replies Count: {{ $lateRepliesCount }}</li>
        @endforeach
    </ul>

  
 

</div>
@endsection
