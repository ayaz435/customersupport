<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
 
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title ?? 'Page Title' }}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="{{ asset('templateassets/css/themes/lite-purple.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('templateassets/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('templateassets/css/plugins/datatables.min.css') }}" />
    @livewireStyles
     <!-- Include Livewire styles -->
</head>
<body>
    @livewire('chat')
   
  
    <script src="{{ asset('templateassets/js/plugins/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/script.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/sidebar.large.script.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/sidebar.script.min.js') }}"></script>
    <script src="{{asset('templateassets/js/scripts/datatables.script.min.js')}}"></script>
    <script src="{{ asset('templateassets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/dashboard.v4.script.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/widgets-statistics.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/apexSparklineChart.script.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/plugins/livewire.js') }}"></script> <!-- Include Livewire script -->
   <!-- Include Livewire scripts -->
    <script>
        setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
        }, 10000); // Hide the alert after 10 seconds (10000 milliseconds)
    </script>
    @livewireScripts
</body>
</html>
