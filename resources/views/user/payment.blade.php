@extends('user.layout.navbar')
@section('content')
<style>
    .active {
        background-color: #4bb750;

    }

.custom-btn {
    font-size: 10px; /* Reduce font size */
    padding: 3px; /* Adjust padding for smaller size */
}


</style>
<div class="main-content">
  

<div class="breadcrumb">
     <h1 class="mr-2">Dashboard</h1> 
     
     <?php
        if($missingData){
            ?>
            <span class="text-danger"><b class="text-danger">!Important missing file.</b> 
            -> <?php echo $missingData; ?>
            </span>  
        <?php } ?>
       
    </div>
  <b>!Please provide your & project details first  by following these steps.</b>

     <ol>
        <div class="row">
        <div class="col-5"><li>Go to Upload BV Details<a href="{{ route('user.bvdetails') }}"><button class="btn btn-primary btn-sm custom-btn mx-2" name="submit" type="submit">UploadData</button></a></li></div>
        
        <div class="col-5"><li>Go to Upload Data Fill Form and submit<a href="{{ route('user.projectform') }}"><button class="btn btn-primary btn-sm custom-btn mx-2" name="submit" type="submit">UploadData</button></a></li></div>
        
        <div class="col-5 mt-2"><li>Go to Upload files to upload neccessary files<a href="{{ route('user.file') }}"><button class="btn btn-primary btn-sm custom-btn mx-2 " name="submit" type="submit">UploadFiles</button></a></li></div>
        
        <div class="col-5 mt-2"><li>Go to Add categories to add catagory<a href="{{ route('user.catagory') }}"><button class="btn btn-primary btn-sm custom-btn mx-2 " name="submit" type="submit">Catagory</button></a></li></div>
        
        <div class="col-5 mt-2"><li>Go to Minisite Portfolio to select minisite design<a href="{{ route('user.design') }}"><button class="btn btn-primary btn-sm custom-btn mx-2" name="submit" type="submit">Minisite</button></a></li></div>
        
        </div>
    </ol>

    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-4">

        <div class="col-md-3 col-lg-3"><a href="{{ route('user.projectdetail') }}">
            <div class="card mb-4 o-hidden" data-route="user.projectdetail">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        {{--  <h5 class="heading">INCOME</h5>  --}}
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Project</h2><small >see your projects progress >> click here</small>
                        </div>
                    </div>
                    {{--  <div id="basicArea-chart"></div>  --}}
                </div>
            </div></a>
                </div>
                <div class="col-md-3 col-lg-3">
                <a href="{{ route('user.payment') }}">
            <div class="card mb-4 o-hidden" data-route="user.payment">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        {{--  <h5 class="heading">APPROVE</h5>  --}}
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Billing</h2><small >see your invoices >> click here</small>
                        </div>
                    </div>
                    {{--  <div id="basicArea-chart2"></div>  --}}
                </div>
            </div></a>
        </div>


       <div class="col-md-3 col-lg-3">
                <a href="{{ route('user.training') }}">
            <div class="card mb-4 o-hidden" data-route="user.training">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                        {{--  <h5 class="heading">transaction</h5>  --}}
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Training</h2><small >professional training videos >> click here</small>
                        </div>
                    </div>
                    {{--  <div id="basicArea-chart3"></div>  --}}
                </div>
            </div>
                </a></div>
                
                 <div class="col-md-3 col-lg-3">
                <a href="{{ route('user.complain') }}">
            <div class="card mb-4 o-hidden" data-route="user.complain">
                <div class="card-body ul-card__widget-chart">
                    <div class="ul-widget__chart-info">
                       {{--  <h5 class="heading">SALES</h5>  --}}
                        <div class="ul-widget__chart-number">
                            <h2 class="t-font-boldest">Ticket</h2><small >generate ticket in case of any delay >> click here</small>
                        </div>
                    </div>
                    {{--  <div id="basicArea-chart4"></div>  --}}
                </div>
            </div></a>
        </div>
        
           
              
               </div>
           
        <!-- finance-->
                
                  <div class="row">        
        <div class="col-md-12 col-lg-12 mt-4"> 
        <h3 class="mr-2">Alibaba Invoices</h3>

            <div class="card o-hidden h-100">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title mb-3"></h4>

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered"  style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SerialNo</th>
                                        <th>Pay Date</th>
                                        <th>Cname</th>
                                         <th>package</th>
                                        <th>Order ID</th>
                                        <th>Payment Status</th>
                                        <th>TotalPkr</th>
                                        <th>Extra Discount</th>
                                        <th>Pay Amount</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($filteredAlibabaData['data']) && is_array($filteredAlibabaData['data']))
                                        @php $serialNumber = 1; @endphp
                                        @foreach ($filteredAlibabaData['data'] as $alibabapayment)
                                            <tr>
                                                <td>{{ $serialNumber++}}</td>
                                                <td>{{ $alibabapayment['pay_date'] }}</td>
                                                <td>{{ auth()->user()->cname }}</td>
                                                <td>{{ $alibabapayment['package'] }}</td>
                                                <td>{{ $alibabapayment['order_id'] }}</td>
                                                <td>{{ $alibabapayment['status'] }}</td>
                                                <td>{{ $alibabapayment['orderDollar']*$alibabapayment['dollar_rate'] }}</td>
                                                <td>{{ $alibabapayment['extra_pkr_discount'] }}</td>
                                                <td>{{ $alibabapayment['amount'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p>No payment data found.</p>
                                    @endif



                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>SerialNo</th>
                                        <th>Pay Date</th>
                                        <th>Cname</th>
                                        <th>package</th>
                                        <th>Order ID</th>
                                        <th>Payment Status</th>
                                        <th>TotalPkr</th>
                                        <th>Extra Discount</th>
                                        <th>Pay Amount</th>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                                             <h3 class="mr-2 mt-3">Invoices</h3>
      
  
            <div class="card o-hidden h-100">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title mb-3"></h4>

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered"  style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SerialNo</th>
                                        <th>Invoice_id</th>
                                        <th>Cname</th>
                                         <th>Item</th>
                                        <th>Detail</th>
                                        <th>TotalPkr</th>
                                        <th>Discount</th>
                                        <th>Pay</th>
                                        <th>Amount</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($paymentData['data']) && is_array($paymentData['data']))
                                    @php $serialNumber = 1; @endphp
                                    @foreach ($paymentData['data'] as $payment)
                                        <tr>
                                            <td>{{ $serialNumber++ }}</td>
                                            <td>{{ $payment['invoice_id'] }}</td>
                                            <td>{{ $payment['cname'] }}</td>
                                            <td>{{ $payment['item'] }}</td>
                                            <td>{{ $payment['detail'] }}</td>
                                            <td>{{ $payment['totalPkr'] }}</td>
                                            <td>{{ $payment['discount'] }}</td>
                                            <td>{{ $payment['pay'] }}</td>
                                            <td>{{ $payment['amount'] }}</td>

                                        </tr>
                                    @endforeach
                                @else
                                    <p>No payment data found.</p>
                                @endif



                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>SerialNo</th>
                                        <th>Invoice_id</th>
                                        <th>Cname</th>
                                         <th>Item</th>
                                        <th>Detail</th>
                                        <th>TotalPkr</th>
                                        <th>Discount</th>
                                        <th>Pay</th>
                                        <th>Amount</th>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                                            
                                            
        </div></div>
                
    
                                            <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the current route
        var currentRoute = "{{ Route::currentRouteName() }}";

        // Get all card elements
        var cards = document.querySelectorAll('.card');

        // Loop through each card and check if its route matches the current route
        cards.forEach(function(card) {
            var cardRoute = card.getAttribute('data-route');

            if (cardRoute === currentRoute) {
                card.classList.add('active'); // Add active class if the route matches
                // Change text color of h2 and small elements
                var cardTitle = card.querySelector('.ul-widget__chart-number h2');
                var cardDescription = card.querySelector('.ul-widget__chart-number small');
                cardTitle.style.color = '#ffffff'; // Change h2 text color to white (or any other color you prefer)
                cardDescription.style.color = '#ffffff'; // Change small text color to white (or any other color you prefer)
            }
        });
    });
</script>
<script>
var dataTableSection = document.getElementById('comma_decimal');
        if (dataTableSection) {
            dataTableSection.scrollIntoView(); // Smooth scroll to the section
        }
</script>
@endsection



