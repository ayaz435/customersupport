
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signin | Gull Admin Template</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="{{asset('templateassets/css/themes/lite-purple.min.css') }}" rel="stylesheet">
</head>
<div class="auth-layout-wrap" style="background-image: url('{{ asset('templateassets/images/photo-wide-4.jpg') }}')">
    <div class="auth-content">
        <div class="card o-hidden">

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
        </div>
    </div>
</div>
