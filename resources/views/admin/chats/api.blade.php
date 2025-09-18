@extends('admin.layout.navbar')
@section('content')
<div class="main-content">

    @if (!empty($data) && is_array($data['data']))
        @foreach ($data['data'] as $item)
            <p>ID: {{ $item['id'] }}</p>
            <p>Company Name: {{ $item['cname'] }}</p>
            <!-- Add more fields as needed -->
            <hr>
        @endforeach
    @else
        <p>No data available.</p>
    @endif



@endsection
