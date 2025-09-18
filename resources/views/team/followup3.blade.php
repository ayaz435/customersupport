@extends('team.layout.navbar')
@section('content')

<div class="main-content">
    @if(session('success'))
    <div id="flash-message" class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="breadcrumb">
        <h1>Customers 3 months old</h1>
    </div>
    @php
    $a = 3;
    @endphp
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="comma_decimal_table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Cid</th>
                                    <th>CName</th>
                                    <th>Phone</th>
                                    <th>Task</th>
                                    <th>Priority</th>
                                    <th>Detail</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>CommunicationType</th>
                                    <th>Status&Action</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                @if($item['adminstatus'] != 'approve')
                                <tr>
                                    <td>{{ $item['id'] }}</td>
                                    <td>{{ $item['cid'] }}</td>
                                    <td>{{ $item['cname'] }}</td>
                                    <td>{{ $item['phone'] }}</td>
                                    <td>{{ $item['task'] }}</td>
                                    <td>{{ $item['priority'] }}</td>
                                    <td>{{ $item['detail'] }}</td>
                                    <td>{{ $item['date'] }}</td>
                                    <td>{{ $item['time'] }}</td>
                                    <form action="{{ route('update.communication.type') }}" id="outerForm"
                                        method="POST">
                                        @csrf
                                        <td>
                                            <input class="form-control" type="text" name="a" hidden value="{{ $a }}">
                                            <input class="form-control" type="text" name="id" hidden
                                                value="{{ $item['id'] }}">
                                            <select class="form-control" name="comunicationtype">
                                                <option value="">Select...</option>
                                                <option value="chat">Chat</option>
                                                <option value="call">Call</option>
                                            </select>
                                        </td>
                                        <td>
                                            @if(isset($item['comunicationtype']))
                                            @if($item['adminstatus']=='')
                                            <div
                                                style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; border: 1px solid #f5c6cb;">
                                                PendingReview
                                            </div>
                                            @elseif($item['adminstatus']=='approve')
                                            <div
                                                style=" background-color: rgba(0, 128, 0, 0.1); color: #006400; padding: 10px; border-radius: 5px; border: 1px solid #f5c6cb;">
                                                Approved
                                            </div>
                                            @elseif($item['adminstatus']=='decline')
                                            <div
                                                style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; border: 1px solid #f5c6cb;">
                                                Decline
                                            </div>
                                            <div id="nestedFormContainer">
    @csrf
    <input class="form-control" type="text" name="fid" hidden value="{{ $a }}">
    <input class="form-control" type="text" name="tid" hidden value="{{ $item['id'] }}">
    <input class="form-control" type="text" name="name" hidden value="{{ $item['team'] }}">
    <textarea class="form-control my-1" name="remarks" id="remarks" placeholder="Enter Remarks"></textarea>
    <a href="javascript:void(0);" class="btn btn-link btn-warning btn-just-icon edit" id="submitButton">
        <i class="material-icons">CompleteAgain</i>
    </a>
</div>

                                            @endif
                                            @else
                                            <button class="btn btn-link btn-warning btn-just-icon edit" type="submit">
                                                <i class="material-icons">Complete</i>
                                            </button>
                                            @endif

                                        </td>
                                        <td>
                                            <a class="btn btn-link btn-info btn-just-icon edit" data-toggle="modal"
                                                data-target="#remarksModal{{$item['id']}}">
                                                <i class="material-icons">Remarks</i>
                                            </a>
                                        </td>
                                    </form>
                                </tr>

                                <!-- Modal for Remarks -->
                                <div class="modal fade" id="remarksModal{{$item['id']}}" tabindex="-1" role="dialog"
                                    aria-labelledby="remarksModalLabel{{$item['id']}}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="remarksModalLabel{{$item['id']}}">Remarks
                                                    for ID {{ $item['id'] }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex justify-content-start ">
                                                        <div class="bg-success px-2 py-2" style="border-radius:5px;">
                                                            <p style="color:white;"><b>Team 2
                                                                </b><span>(22/12/2013)</span></p>
                                                            <p style="color:white;">Remarks from team member 2</p>
                                                        </div>


                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <div class="bg-danger px-2"
                                                            style="color:white; border-radius:10px; height:20px;">
                                                            Decline</div>
                                                        <div class=" px-2 py-2"
                                                            style="border-radius:5px; border:1px solid lightgrey">
                                                            <p><b>Manager </b><span>(22/12/2013)</span></p>
                                                            <p>Remarks from Manager</p>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Cid</th>
                                    <th>CName</th>
                                    <th>Phone</th>
                                    <th>Task</th>
                                    <th>Priority</th>
                                    <th>Detail</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>CommunicationType</th>
                                    <th>Status&Action</th>
                                    <th>Remarks</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function () {
    // Use event delegation in case the element is loaded dynamically
    $(document).on('click', '#submitButton', function (e) {
        e.preventDefault(); // Prevent the default anchor behavior
        console.log('Anchor clicked'); // Debugging output to verify click event

        // Collect all data
        let data = {
            _token: $('input[name="_token"]').val(), // CSRF token
            fid: $('input[name="fid"]').val(),
            id: $('input[name="tid"]').val(),
            name: $('input[name="name"]').val(),
            remarks: $('#remarks').val(),
        };

        // AJAX request
        $.ajax({
            url: "{{ route('nested.form.submit') }}", // Route defined in Laravel
            type: 'POST',
            data: data,
            success: function (response) {
                // Handle success response
                alert('Form submitted successfully!');
                console.log(response);
            },
            error: function (xhr, status, error) {
                // Handle error response
                alert('An error occurred. Please try again.');
                console.error(xhr.responseText);
            }
        });
    });
});

</script>


@endsection