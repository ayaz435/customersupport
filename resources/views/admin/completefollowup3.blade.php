@extends('admin.layout.navbar')
@section('content')
<style>
    #comma_decimal_table th, 
    #comma_decimal_table td {
        word-wrap: break-word;
        white-space: normal;
    }

    #comma_decimal_table td:nth-child(12), 
    #comma_decimal_table th:nth-child(12) {
        min-width: 150px; /* Adjust as needed */
    }
</style>

<div class="main-content">
    @if(session('success'))
    <div id="flash-message" class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="breadcrumb">
        <h1>Customers <?php if($month===9) echo "1 years"; else echo $month." months"; ?>  old</h1>
    </div>
@php
$a=6;
@endphp
    <!-- end of row-->
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="comma_decimal_table" style="width:100%; table-layout: auto;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Cid</th>
                                    <th>CName</th>
                                    <th>Team</th>
                                    <th>Phone</th>
                                    <th>Task</th>
                                    <th>Detail</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>C_Type</th>
                                    <th>Team Status</th>
                                    <th>Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item['id'] }}</td>
                                        <td>{{ $item['cid'] }}</td>
                                        <td>{{ $item['cname'] }}</td>
                                        <td>{{ $item['team'] }}</td>
                                        <td>{{ $item['phone'] }}</td>
                                        <td>{{ $item['task'] }}</td>
                                        <td>{{ $item['detail'] }}</td>
                                        <td>{{ $item['date'] }}</td>
                                        <td>{{ $item['time'] }}</td>
                                        <td>
                                           {{$item['comunicationtype']}}
                                        </td>
                                        <td>{{$item['teamstatus']}}</td>
                                        
                                        <td style="word-wrap: break-word; white-space: normal; font-size: 12px;">
                                            @if($item['adminstatus']==="approve")
                                                <div class="d-flex align-items-center justify-content-center py-1" 
                                                    style=" border-radius: 5px; border: 2px solid #006400; background-color: rgba(0, 128, 0, 0.1); 
                                                    color: #006400; font-size: 1.2rem; font-weight: bold; font-size:12px;">
                                                    <span>✔️</span>
                                                </div>
                                            @elseif($item['teamstatus'] !== "Complete")
                                                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; border: 1px solid #f5c6cb;">
                                                    Task Pending
                                                </div>
                                            @else    
                                                <form action="{{ route('update.admim.approve.status')}}" method="POST">
                                                    @csrf
                                                    <input class="form-control" type="text" name="a" hidden value="{{$month}}">
                                                    <input class="form-control" type="text" name="id" hidden value="{{$item['id']}}">
                                                    <div class="d-flex align-items-center justify-content-center py-1" >
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <select class="form-control"  name="adminstatus" id="">
                                                                <option value="">Select...</option>
                                                                <option value="approve">Approve</option>
                                                                <option value="decline">Decline</option>
                    
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <button class="btn btn-link btn-warning btn-just-icon edit" type="submit">
                                                                <i class="material-icons">Submit</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    </div>
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
                                    <th>Team</th>
                                    <th>Phone</th>
                                    <th>Task</th>
                                    <th>Detail</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>C_Type</th>
                                    <th>Team Status</th>
                                    <th>Status</th>
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
