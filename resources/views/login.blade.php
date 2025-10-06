
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signin | Gull Admin Template</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="{{asset('templateassets/css/themes/lite-purple.min.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="auth-layout-wrap" style="background-image: url('{{ asset('templateassets/images/photo-wide-9.jpg') }}?t={{ time() }}')">
        <div class="auth-content">
            <div class="absolute top-0 left-0 p-4 bg-transparent">
                <div class="bg-transparent text-white w-50 mt-4 ml-4" style="width:500px !important;">
                    <h1 class="font-bold text-2xl text-white pt-4 pb-4" style="font-size: 38px; line-height:1.1;">Delivering Trusted Support to Empower Your Success.</h1>
                    <p style="font-size: 20px;">Welcome to the Webexcels Customer Support Portal, we are committed to providing you with reliable, efficient, and personalized support.</p>
                    <div class="mt-4">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#signInModal" class="btn btn-success mr-2">Sign In</a>
                        <a href="javascript:void(0)" class="btn btn-outline-success text-white">Register Account</a>
                    </div>
                </div>
            </div>
            <div class="modal fade mt-4" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 350px;">
                    <div class="modal-content" style="background-color: rgba(255, 255, 255, 0.6);"> <!-- Transparent and Opacity applied here -->
                        <div class="modal-body">
                            <div class="p-4">
                                @include('admin.message')
                                <div class="auth-logo text-center mb-4"><img src="{{ asset('templateassets/images/logo.png') }}" alt="" class="mx-auto d-block" style="width: 9rem; object-fit: contain;"></div>
                                <h1 class="mb-3 text-18">Sign In</h1>
                                <form action="{{route('authenticate')}}" method="post">@csrf
                                    <div class="form-group">
                                        <label for="email" class="text-dark">Email address</label>
                                        <input  style="opacity: 0.6;" class="form-control  form-control-rounded @error('email') is-invalid @enderror" value="{{old('email')}}" id="email" type="email" name="email">
                                        @error('email')
                                    <p class="invalid-feedback">{{ $message}}</p>
                                @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="text-dark">Password</label>
                                        <input style="opacity: 0.6;" class="form-control form-control-rounded @error('password') is-invalid @enderror" value="{{old('password')}}" id="password" type="password" name="password">
                                        @error('password')
                                        <p class="invalid-feedback">{{ $message}}</p>
                                    @enderror
                                    </div>
                                    <button type="submit" class="btn btn-rounded btn-success btn-block mt-2">Sign In</button>
                                </form>
                                <div class="mt-3 text-center">
                                    <a class="text-dark" href="forgot.html"><u>Forgot Password?</u></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="card o-hidden">

                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            @include('admin.message')
                            <div class="auth-logo text-center mb-4"><img src="{{ asset('templateassets/images/logo.png') }}" alt=""></div>
                            <h1 class="mb-3 text-18">Sign In</h1>
                            <form action="{{route('authenticate')}}" method="post">@csrf
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input class="form-control  form-control-rounded" value="{{old('email')}}" id="email" type="email" name="email">
                                    @error('email')
                                <p class="invalid-feedback">{{ $message}}</p>
                            @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control form-control-rounded" value="{{old('password')}}" id="password" type="password" name="password">
                                    @error('password')
                                    <p class="invalid-feedback">{{ $message}}</p>
                                @enderror
                                </div>
                                <button type="submit" class="btn btn-rounded btn-primary btn-block mt-2">Sign In</button>
                            </form>
                            <div class="mt-3 text-center"><a class="text-muted" href="forgot.html">
                                    <u>Forgot Password?</u></a></div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center" style="background-size: cover;background-image: url({{ asset('templateassets/images/photo-long-3.jpg') }})">

                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>    
    <script>
        document.querySelector("form").addEventListener("submit", function(event) {
            const emailField = document.getElementById("email");
            const passwordField = document.getElementById("password");

            if (emailField.classList.contains("is-invalid") || passwordField.classList.contains("is-invalid")) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>