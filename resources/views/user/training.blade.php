@extends('user.layout.navbar')
@section('content')
<div class="container">
<h2>Video Tutorials</h2>
    <div class="row">
        @foreach ($trainingData['data'] as $training)
        <div class="col-4">
            @php
                // Append "embed/" after "https://www.youtube.com/"
                $embeddedUrl = str_replace('https://www.youtube.com/', 'https://www.youtube.com/embed/', $training['url']);
            @endphp
            <!-- Assuming $training['url'] contains the YouTube video URL -->
            <iframe id="videoFrame" width="300" height="200" src="{{ $embeddedUrl }}" frameborder="0" allowfullscreen></iframe>
            
            <p><b>{{ $training['title'] }}</b></p>
            <p>{{ $training['desc'] }}</p>
            <!-- Add any additional information you want to display -->
        </div>
        @endforeach
    </div>
</div>

@endsection
