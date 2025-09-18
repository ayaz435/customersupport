<!DOCTYPE html>
<html lang="en" dir="">


<!-- Mirrored from demos.ui-lib.com/gull/html/layout1/dashboard4.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Apr 2021 18:38:21 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Dashboard v4 | Gull Admin Template</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="{{ asset('templateassets/css/themes/lite-purple.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('templateassets/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('templateassets/css/plugins/datatables.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
   .custom-datepicker {
    background-color: lightgreen;
    width: 12%;
    font-family: Arial, sans-serif;
    color: white;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding-left:15px;
}


.custom-datepicker .ui-datepicker-header {
    background-color: lightgreen;
    color: white;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

.custom-datepicker .ui-datepicker-title {
    font-size: 16px;
    font-weight: bold;
    text-align: center; /* Add this line to center-align the text */
    padding: 10px 0;
}

.custom-datepicker .ui-datepicker-prev,
.custom-datepicker .ui-datepicker-next {
    background-color: lightgreen;
    color: white;
    font-size: 14px;
    padding: 5px;
    border-radius: 50%;
}

.custom-datepicker .ui-datepicker-prev:hover,
.custom-datepicker .ui-datepicker-next:hover {
    background-color: darkgreen;
}

.custom-datepicker .ui-state-default {
    background-color: lightgreen;
    color: white;
    border-radius: 50%;
}

.custom-datepicker .ui-state-default:hover {
    background-color: darkgreen;
}

.custom-datepicker .ui-datepicker-current-day {
    background-color: darkgreen;
    color: white;
}

.custom-datepicker .ui-datepicker-calendar td span {
    font-size: 14px;
}

.custom-datepicker .ui-datepicker-calendar td a {
    color: white;
}

.custom-datepicker .ui-datepicker-calendar td a:hover {
    background-color: darkgreen;
}

.fixed-img-container {
    position: fixed;
    bottom: -20px; /* Adjust as needed */
    right: -940px; /* Adjust as needed */
    z-index: 9999; /* Ensure it appears above other content */
}


.loader-container {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loader {
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top: 8px solid #4CAF50; /* Change to desired color */
    width: 60px;
    height: 60px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loader-text {
    color: #fff;
    font-size: 20px;
    margin-top: 20px;
}

.progress-bar {
    width: 200px;
    height: 20px;
    background-color: #ccc;
    margin-top: 20px;
}

.progress {
    height: 100%;
    width: 0;
    background-color: #4CAF50; /* Change to desired color */
}

</style>
</head>

<body class="text-left" >
@if(auth()->check())
    <script>
        window.addEventListener("beforeunload", function () {
            navigator.sendBeacon("/user-leaving");
        });
    </script>
@endif

 <div class="loader-container" id="loaderContainer">
        <div class="loader"></div>
        <div class="loader-text" id="loaderText">Please wait...</div>
        <div class="progress-bar">
            <div class="progress" id="progressBar"></div>
        </div>
    </div>
    <div class="app-admin-wrap layout-sidebar-large">
       @yield('navbars')
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <!-- ============ Body content start ============= -->
            @yield('content')
            <!-- Footer Start -->
            <div class="flex-grow-1"></div>

            <!-- fotter end -->
        </div>
    </div><!-- ============ Search UI Start ============= -->
    <div class="search-ui">
        <div class="search-header">
            <img src="../../dist-assets/images/logo.png" alt="" class="logo">
            <button class="search-close btn btn-icon bg-transparent float-right mt-2">
                <i class="i-Close-Window text-22 text-muted"></i>
            </button>
        </div>
        <input type="text" placeholder="Type here" class="search-input" autofocus>
        <div class="search-title">
            <span class="text-muted">Search results</span>
        </div>
        <div class="search-results list-horizontal">
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="../../dist-assets/images/products/headphone-1.jpg" alt="">
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="#" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">$300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-danger">Sale</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="../../dist-assets/images/products/headphone-2.jpg" alt="">
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="#" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">$300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-primary">New</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="../../dist-assets/images/products/headphone-3.jpg" alt="">
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="#" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">$300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-primary">New</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="../../dist-assets/images/products/headphone-4.jpg" alt="">
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="#" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">$300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-primary">New</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGINATION CONTROL -->
        <div class="col-md-12 mt-5 text-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination d-inline-flex">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- ============ Search UI End ============= -->
    
    <div class="fixed-img-container">
    <a href="https://webexcels.com.pk/customersupport/chat/login" target="_blank"><img style="width:15%;" src="{{asset ('templateassets/images/Live-Chat.png') }}" alt="Your Image"></a>
</div>
<script>
        $(document).ajaxStart(function() {
            // Show loader when AJAX request starts
            $('#loaderContainer').css('display', 'flex');

            // Start progress bar animation
            let progress = 0;
            const interval = setInterval(function() {
                progress += 1;
                document.getElementById("progressBar").style.width = `${progress}%`;
                if (progress >= 100) {
                    clearInterval(interval);
                }
            }, 30);
        });

        $(document).ajaxStop(function() {
            // Hide loader when AJAX request completes
            $('#loaderContainer').css('display', 'none');
        });
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha384-dFso2TaQeZW5UdtCax/6FqYa9xaxYDpeZZH/6I1jR6IIpBpL5+fkg8GNVIz9LI+e" crossorigin="anonymous"></script>

    <script src="{{ asset('templateassets/js/plugins/jquery-3.3.1.min.js') }}"></script>

    <script src="{{ asset('templateassets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/script.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/sidebar.large.script.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/plugins/echarts.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/echart.options.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/datatables.script.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/dashboard.v4.script.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/widgets-statistics.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('templateassets/js/scripts/apexSparklineChart.script.min.js') }}"></script>
    <script>
        window.addEventListener("beforeunload", function () {
            navigator.sendBeacon("/user-leaving");
        });
    
    
        setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
        }, 10000); // Hide the alert after 10 seconds (10000 milliseconds)
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Your Blade View -->


    <!-- Your Blade View -->

<script>
$(document).ready(function() {


    window.addEventListener("beforeunload", function () {
        navigator.sendBeacon("/user-leaving");
    });


    var table = $('#comma_decimal_table').DataTable();

    // Add event listener for the date filter inputs
    $('#fromDate, #toDate').on('change', function() {
        // Get the from and to date values
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

        // Perform the date range filtering
        table.columns(0).search(fromDate + ' - ' + toDate).draw();
    });
});
$(document).ready(function() {
  var fromDate, toDate;
  var table = $('#comma_decimal_table').DataTable();

  $('#fromDate').datepicker({
    dateFormat: 'yy-mm-dd',
    onSelect: function(selectedDate) {
      fromDate = selectedDate;
      applyDateFilter();
    },
    beforeShow: function(input, inst) {
      inst.dpDiv.addClass('custom-datepicker');
    }
  });

  $('#toDate').datepicker({
    dateFormat: 'yy-mm-dd',
    onSelect: function(selectedDate) {
      toDate = selectedDate;
      applyDateFilter();
    },
    beforeShow: function(input, inst) {
      inst.dpDiv.addClass('custom-datepicker');
    }
  });

  function applyDateFilter() {
    if (fromDate && toDate) {
      table.draw();
    }
  }

  $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
    var date = data[0]; // Assuming the date column is the first column

    if (!fromDate && !toDate) {
      return true;
    }

    if (fromDate && !toDate) {
      return date >= fromDate;
    }

    if (!fromDate && toDate) {
      return date <= toDate;
    }

    return date >= fromDate && date <= toDate;
  });

  $('#comma_decimal_table').DataTable().draw();
});

</script>
    <script>
        $(document).ready(function () {
            // Function to fetch user API data
            function fetchUserApiData() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route("admin.chatuser.api") }}',
                    dataType: 'json',
                    success: function (response) {
                        console.log(response.message);
                    },
                    error: function (error) {
                        console.log('Error:', error);
                    }
                });
            }

            // Call fetchUserApiData initially
            fetchUserApiData();

            // Set up a timer to call fetchUserApiData every 15 seconds
            setInterval(fetchUserApiData, 120000);

            // Function to fetch team API data
            function fetchTeamApiData() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route("admin.chatteam.api") }}',
                    dataType: 'json',
                    success: function (response) {
                        console.log(response.message);
                    },
                    error: function (error) {
                        console.log('Error:', error);
                    }
                });
            }

            // Call fetchTeamApiData initially
            fetchTeamApiData();

            // Set up a timer to call fetchTeamApiData every 15 seconds
            setInterval(fetchTeamApiData, 120000);
        });
    </script>


</body>


<!-- Mirrored from demos.ui-lib.com/gull/html/layout1/dashboard4.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Apr 2021 18:38:28 GMT -->
</html>
