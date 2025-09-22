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
                                <form action="{{ Route('register.store') }}" method="post">@csrf
                                    <div class="form-group">
                                        <label for="username">Your name</label>
                                        <input value="{{old('name')}}" name="name" class="form-control form-control-rounded" id="username" type="text">
                                        @error('name')
                        <p class="invalid-feedback">{{ $message}}</p>
                       @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input value="{{old('email')}}" name="email" class="form-control form-control-rounded" id="email" type="email">
                                        @error('email')
                        <p class="invalid-feedback">{{ $message}}</p>
                       @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input value="{{old('password')}}" name="password" class="form-control form-control-rounded" id="password" type="password">
                                        @error('password')
                        <p class="invalid-feedback">{{ $message}}</p>
                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="picker1">Role</label>
                                        <select name="role" class="form-control form-control-rounded">
                                            <option readonly>Select Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="team">Team</option>
                                            <option value="user">User</option>
                                            <option value="service">Service</option>
                                        </select>
                                        @error('role')
                           <p class="invalid-feedback">{{ $message}}</p>
                          @enderror
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary btn-block btn-rounded mt-3">Sign Up</button>
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
