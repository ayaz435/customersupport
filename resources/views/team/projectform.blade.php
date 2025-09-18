@extends('team.layout.navbar')
@section('content')
<div class="main-content">

    <div class="breadcrumb">
        <h1>Complains</h1>

    </div>
    <form method="POST" action="{{ route('projectform.submit') }}">
        @csrf
    <div class="row">
         <div class="col-md-3 form-group mb-3">
        <label for="picker1">Select Related Catagory</label>
        <select class="form-control" name="email">
            <option value="">Select Email</option>
           @php
        $uniqueEmails = $eemails->toArray();
        $uniqueEmails = array_unique($uniqueEmails);
    @endphp
    @foreach($uniqueEmails as $eemail)
        <option value="{{ $eemail }}">{{ $eemail }}</option>
    @endforeach
        </select>
        @error('email')
        <p class="invalid-feedback">{{ $message}}</p>
    @enderror
    </div>
        <div class="col-md-1 form-group mt-4">
            <button class="btn btn-primary" name="submit" type="Search">Submit</button>
        </div>
    </div>
    </form>

    <!-- end of row-->

</div>


@endsection
