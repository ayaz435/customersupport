@extends('team.layout.navbar')
@section('content')
<div class="main-content">
    @if(session('success'))
    <div id="flash-message" class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="breadcrumb">
        <h1>Customers <?php if($month===9) echo "1 years"; else echo $month." months"; ?>  old</h1>
    </div>

    <!-- end of row-->
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="comma_decimal_table" style="width:100%">
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
                                    <!--<th>Time</th>-->
                                    <th>CommunicationType</th>
                                    <th>Admin Status</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item['id'] }}</td>
                                        <td>{{ $item['cid'] }}</td>
                                        <td>{{ $item['cname'] }}</td>
                                        <td>{{ $item['phone'] }}</td>
                                        <td>{{ $item['task'] }}</td>
                                        <td>{{ $item['priority'] }}</td>
                                        <td>{{ $item['detail'] }}</td>
                                        <td>{{ $item['date'] }}</td>
                                        <td>
                                            @if(!empty($item['comunicationtype']))
                                                <ul class="mb-0 pl-3">
                                                    @foreach(explode(', ', $item['comunicationtype']) as $type)
                                                        <li>{{ trim($type) }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <em>No communication</em>
                                            @endif
                                        </td>
                                        <td>{{ $item['adminstatus'] }}</td>
                                        <td>
                                            @if(isset($item['adminstatus']) && $item['adminstatus']==="approve")
                                                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; border: 1px solid #f5c6cb;">
                                                    Task Completed
                                                </div>
                                            @elseif(isset($item['teamstatus']) && $item['teamstatus']==="Complete")
                                                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; border: 1px solid #f5c6cb;">
                                                    PendingReview
                                                </div>
                                            @else
                                                <form action="{{ route('update.communication.type') }}" method="POST">
                                                @csrf
                                                    <input class="form-control" type="text" name="followup_type" hidden value="{{$month}}">
                                                    <input class="form-control" type="text" name="id" hidden value="{{$item['id']}}">
                                                    <button class="btn btn-link btn-warning btn-just-icon edit" type="submit">
                                                        <i class="material-icons">Complete</i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                       
                                    </tr>
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
                                    <!--<th>Time</th>-->
                                    <th>CommunicationType</th>
                                    <th>Admin Status</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Task Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="#">
                    <input type="hidden" name="cid" id="modalId">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Company</label>
                                <input type="text" class="form-control" name="company" id="modalCname">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select Task Name</label>
                                <select class="form-control" name="task" id="exampleFormControlSelect1">
                                    <option>Select...</option>
                                    <option value="team">Task 1</option>
                                    <option value="user">Task 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select Teammember to assign</label>
                                <select class="form-control" name="team" id="exampleFormControlSelect1">
                                    <option>Select TeamMember</option>
                                    <option value="team">Team 1</option>
                                    <option value="user">Team 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Date</label>
                                <input class="form-control" type="date" name="date">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Time</label>
                                <input class="form-control" type="time" name="time">
                            </div>
                        </div>
                    </div>
                    <h4>Priority</h4>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input class="p-1" type="radio" name="priority">
                                <label for="exampleFormControlSelect1">Urgent</label>
                                <input class="p-1" type="radio" name="priority">
                                <label for="exampleFormControlSelect1">Normal</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Details</label>
                        <textarea class="form-control" name="detail" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
