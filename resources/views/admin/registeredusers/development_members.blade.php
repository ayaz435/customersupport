@extends('admin.layout.navbar')
@section('content')
<div class="main-content">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <script>
          setTimeout(function () {
              let alert = document.getElementById('success-alert');
              if (alert) {
                  alert.classList.remove('show');
                  alert.classList.add('fade');
                  alert.style.display = 'none';
              }
          }, 4000);
      </script>
    @endif

    <div class="breadcrumb"> <h1>D&D Members</h1> </div>
    <!-- end of row-->
    <div class="row mb-4">
        {{-- <a href="javascript:void(0)" class="btn btn-success ml-3 mb-3 px-5 w-auto">Register Service User</i></a>
        <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal"  class="btn btn-danger ml-3 mb-3 px-5 w-auto">Announcement</a> --}}
        <!-- end of col-->
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="comma_decimal_table" style="width:100%; border-collapse: collapse !important;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>DRM ID</th>
                                    <th>Name</th>
                                    <th>CName</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    {{-- <th>Team Catagory</th> --}}
                                    <th>Created Date</th>
                                    {{-- <th>Action date</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach  ($development_members as $registereduser )
                                  <tr>
                                    <td>{{ $registereduser->id }}</td>
                                    <td>{{ $registereduser->drm_user_id ?? 'N/A'}}</td>
                                    <td>{{ $registereduser->name }}</td>
                                    <td>{{ $registereduser->cname  ?? 'N/A'}}</td>
                                    <td>{{ $registereduser->email }}</td>
                                      <td>
                                          @if($registereduser->details && $registereduser->details->password)
                                              {{ $registereduser->details->password }}
                                          @else
                                               N/A
                                          @endif
                                      </td>
                                    {{-- <td>{{ ucfirst($registereduser->role) }}</td> --}}
                                    <td>{{ ucwords(str_replace(',', ' &', $registereduser->designation ?? 'N/A')) }}</td>
                                    <td>{{ $registereduser->created_at }}</td>
                                    {{-- <td class="text-right">
                                        <a href="{{route('admin.registeredusers.edit', ['id' => $registereduser->id, 'type' => 'service'])}}" class="btn btn-warning edit">Edit</a>
                                        <a href="{{route('admin.registeredusers.del', $registereduser->id)}}" class="btn btn-danger remove">Delete</a>
                                    </td> --}}
                                  </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end of col-->
    </div> <!-- end of row-->
</div> <!-- end of main-content -->

@endsection
