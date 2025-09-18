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

    <!-- end of row-->
    <div class="row mb-4">


        <!-- end of col-->
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <form id="filterForm" action="{{ route('admin.chatsfetch') }}" method="GET" >
                    <span class="card-title mb-3">
                    <div class="form-group">
                        <label for="picker1">Select Team Member</label>
                        <select id="team_member" name="team" class="form-control form-control-rounded col-2">
                            <option readonly>Select TeamMember</option>
                            @foreach($teamMembers as $teamMemberId => $teamMemberName)
                            <option value="{{ $teamMemberId }}">{{ $teamMemberName }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="picker1">Select Team Member</label>
                        <select id="user" name="team" class="form-control form-control-rounded col-2">
                            <option readonly>Select </option>
                            @foreach($users as $userId => $userName)
                    <option value="{{ $userId }}">{{ $userName }}</option>
                @endforeach
                        </select>
                    </div>
                    <button type="submit" id="filterBtn" class="btn btn-link btn-danger btn-just-icon remove">
                        <i class="material-icons">Search</i>
                    </button>
                </span>
                <form>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered " id="comma_decimal_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Message</th>
                                    <th>Action date</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ch_messages as $chat)
                                <tr>
                                    <td>{{ $chat->from_name }}</td>
                                    <td>{{ $chat->to_name }}</td>
                                    <td>{{ $chat->body }}</td>
                                    <td></td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.chats.del', $chat->id) }}" class="btn btn-link btn-danger btn-just-icon remove">
                                            <i class="material-icons">close</i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Message</th>
                                    <th>Action date</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of col-->

        <!-- end of col-->
    </div>
    <!-- end of row-->
    <!-- end of main-content -->
</div>
// Your JavaScript file or inline script in Blade view
<script>
    $(document).ready(function () {
        // Event listener for filter button
        $('#filterBtn').on('click', function () {
            // Submit the form with selected values for filtering
            $('#filterForm').submit();
        });
    });
</script>
@endsection
