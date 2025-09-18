@extends('user.layout.navbar')
@section('content')

<div class="main-content">
  

<div class="breadcrumb">
        <h1 class="mr-2">User Dashboard</h1>
        
        <?php
        if($missingData){
            ?>
            <span class="text-danger"><b class="text-danger">!Important missing file.</b> 
            -> <?php echo $missingData; ?>
            </span>  
        <?php } ?>
       
    </div>


  
   
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="card mt-4">
                <div class="card-body">
                    <!-- right control icon-->
                    @if(session('success'))
                    <div id="flash-message" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">

                              <form action="{{ route('user.submitmodification') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-title mb-3">Tell us Changes that you want</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="fileInput">Upload Image*</label>
                                            <input class="form-control" id="fileInput" name="file" type="file" required />
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="detailInput">Changes Detail</label>
                                            <textarea class="form-control" id="detailInput" name="detail" required></textarea>
                                        </div>

                                        <input type="hidden" name="modification" value="Completed">
                                        <input type="hidden" name="client_status" value="Approved">
                                        <input type="hidden" name="pro_id" value="{{ $pro_id ?? '' }}">
                                        <input type="hidden" name="assign_user" value="{{ $assign_user ?? '' }}">
                                        <input type="hidden" name="com_id" value="{{ $com_id ?? '' }}">
                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- /right control icon-->
                </div>
            </div>
        </div>

    </div><!-- end of main-content -->
</div>
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
document.getElementById('modificationForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('https://webexcels.pk/api/update_project', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
        },
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || 'Updated!');
    })
    .catch(err => {
        console.error(err);
        alert('Error occurred!');
    });
});

</script>
@endsection
