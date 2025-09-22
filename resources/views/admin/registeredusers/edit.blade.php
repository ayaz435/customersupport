@extends('layout.app')
@section('content')
<div class="main-content">
    <div class="breadcrumb">
        <h1>Basic</h1>
        <ul>
            <li><a href="href.html">Form</a></li>
            <li>Basic</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-4">
                                <h1 class="mb-3 text-18">Register Users</h1>
                                <form action="{{ Route('admin.registeredusers.update',$users->id) }}" method="post">@csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="username">Your name</label>
                                        <input value="{{ old('name', $users->name) }}" name="name" class="form-control form-control-rounded" id="username" type="text">
                                        <span class="text-danger">@error('name'){{ $message }}@enderror</span>

                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input value="{{ old('email', $users->email) }}" name="email" class="form-control form-control-rounded" id="username" type="text">
                                        <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input value="{{ old('password', $users->password) }}" name="password" class="form-control form-control-rounded" id="username" type="text">
                                        <span class="text-danger">@error('password'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="picker1">Role</label>
                                        <input value="{{ old('role', $users->role) }}" name="role" class="form-control form-control-rounded" id="username" type="text">
                                        <span class="text-danger">@error('role'){{ $message }}@enderror</span>
                                    </div>
                                        <input type="hidden" name="type" value="{{ $type }}">
                                    <button type="submit" name="submit" class="btn btn-primary btn-block btn-rounded mt-3">Update</button>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div><!-- end of main-content -->
</div>
@endsection
