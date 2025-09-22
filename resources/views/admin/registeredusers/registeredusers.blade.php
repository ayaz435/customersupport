@extends('admin.layout.navbar')
@section('content')
<div class="main-content">
    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="breadcrumb">
        <h1>Client Team Members</h1>

    </div>

    <!-- end of row-->
    <div class="row mb-4">
        {{-- <a href="{{ route('register') }}" class="btn btn-success ml-3 mb-3 px-5 w-auto">Register User</a> --}}
        {{-- <a href="{{ route('register') }}" class="btn btn-link btn-success btn-just-icon remove ml-3 mb-3 px-5"><i class="material-icons">Register User</i></a>
    <a href="" data-toggle="modal" data-target="#exampleModal"  class="btn btn-link btn-danger btn-just-icon remove ml-3 mb-3 px-5"><i class="material-icons">Announcement</i></a> --}}
        <!-- end of col-->
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    {{-- <h4 class="card-title mb-3">Language - Comma decimal place</h4> --}}

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="comma_decimal_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>DRM ID</th>
                                    <th>Name</th>
                                    <th>CName</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Team Catagory</th>
                                    <th>Created Date</th>
                                    {{-- <th>Action date</th> --}}

                                </tr>
                            </thead>
                            <tbody>
                                @foreach  ($users as $registereduser )
                                <tr>
                                  <td>{{ $registereduser->id }}</td>
                                  <td>{{ $registereduser->drm_user_id }}</td>
                                  <td>{{ $registereduser->name }}</td>
                                  <td>{{ $registereduser->cname ?? 'N/A'}}</td>
                                  <td>{{ $registereduser->email }}</td>
                                    <td>
                                        @if($registereduser->details && $registereduser->details->password)
                                            {{ $registereduser->details->password }}
                                            asdf
                                        @else
                                            {{ $registereduser->password }}qwer
                                        @endif
                                    </td>
                                  <td>{{ $registereduser->role }}</td>
                                  <td>{{ $registereduser->designation ?? 'N/A'}}</td>
                                  <td>{{ $registereduser->created_at }}</td>
                                  {{-- <td class="text-right">
                                    <a href="{{route('admin.registeredusers.edit', ['id' => $registereduser->id, 'type' => 'user'])}}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">Edit</i></a>
                                    <a href="{{route('admin.registeredusers.del', $registereduser->id)}}" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
                                  </td> --}}
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
    <th>CName</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Team Catagory</th>
                                    <th>Created Date</th>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Announcement Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('inbox.store')}}"> @csrf
          <div class="form-group">
            <label for="exampleFormControlSelect1">Select Role to Send Announcement</label>
            <select class="form-control" name="role" id="exampleFormControlSelect1">
              <option>Select Role</option>
              <option value="team">Team</option>
              <option value="user">Client</option>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Enter Announcement</label>
            <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


    
@endsection
