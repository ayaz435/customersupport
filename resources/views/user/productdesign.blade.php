@extends('user.layout.navbar')
@section('content')
<style>
.select-design-checkbox
{
 width: 15px; /* Set the desired width */
    height: 15px;

/* Set the desired height */
}
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption { 
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* Close Button */
.close {
  position: absolute;
  top: 115px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}
     .portfolio-design {
        position: relative;
    }

    .buttons-container {
        position: absolute;
        bottom: 10px;
        right: 20px;
        display: none;
    padding-left:10px;
     padding-right:10px;
     padding-top:10px;
     padding-bottom:10px;
    background-color:lightgreen;
    }

    .portfolio-design:hover .buttons-container {
        display: block;
    }

    .view-full-design-btn,
    .select-design-btn {
        background-color: #ffffff;
        border: 1px solid #4bb750;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
        margin-left: 5px;
    }

    /* Your existing styles */
    .active {
        background-color: #4bb750;
    }

    .custom-btn {
        font-size: 10px;
        padding: 3px;
    }

    /* Added CSS for sub-categories */
    .sub-category {
        cursor: pointer;
        padding: 5px;
        margin: 5px 0;
        border-radius: 5px;
        background-color: #f0f0f0;
        transition: background-color 0.3s ease;
    }

    .sub-category:hover {
        background-color: #e0e0e0;
    }

    /* Added CSS for portfolio designs */
    .portfolio-design-img {
    max-width: 100%;
        min-width: 100%;
        max-height: 40vh;
     min-height: 40vh;/* Set a fixed height */
        object-fit: cover; /* Ensure the image covers the container */
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }

    .portfolio-design-img:hover {
        transform: scale(1.05);
    }
.image {
    max-width: 100%;
    min-width: 100%;

    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Add box-shadow transition */
}
.image:hover {
    transform: scale(1.05); /* Zoom effect on hover */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add box shadow on hover */
}

#stickyBar {
    display: none;
    position: fixed;
    bottom: 0;
    left: 50%; /* Position it at the horizontal center */
    transform: translateX(-50%); /* Adjust to center it properly */
    width: 80%; /* Set the desired width */
    max-width: 700px; /* Adjust the maximum width as needed */
    padding: 10px 0;
    background-color: #f8f9fa; /* Bootstrap background color */
    box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.2); /* Add a shadow effect */
    z-index: 999; /* Ensure the sticky bar is above other content */
}

  .heading2
  {
  background-color:lightgreen;
  }  
</style>



<div class="row">
    @if($categories)
        @php $category = $categories; @endphp
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <h2 class="heading2 my-4">{{ $category['name'] }}</h2>
            <div class="container">
                <div class="row">
                    @foreach ($main_images as $mainImage)
                        <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                            <div class="portfolio-design">
                                <a href="https://webexcels.pk/drm/assets/posting_data/{{ $mainImage['img'] }}" target="blank">
                                    <img class="img-fluid image portfolio-design-img" src="https://webexcels.pk/drm/assets/posting_data/{{ $mainImage['img'] }}" alt="Main Image">
                                </a>
                                <div class="buttons-container">
                                    <label> <b>Select</b></label>
                                    <input type="checkbox" 
                                       class="select-design-checkbox" 
                                       value="{{ $mainImage['id'] }}"
                                       data-design='@json($mainImage)'
                                       data-img-url="https://webexcels.pk/drm/assets/posting_data/{{ $mainImage['img'] }}">
                                </div>
                            </div>
                            <div class="mt-2">
                                <h3>Views</h3>
                                <div class="row">
                                    @if(isset($mainImage['products']))
                                        @foreach ($mainImage['products'] as $view)
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-4">
                                                <a href="https://webexcels.pk/drm/assets/posting_data/{{ $view['images'] }}" target="blank">
                                                    <img class="img-fluid image" src="https://webexcels.pk/drm/assets/posting_data/{{ $view['images'] }}" alt="View Image">
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12">
                                            <p>No views available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Pagination Section -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($main_images->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $main_images->previousPageUrl() }}" rel="prev">Previous</a>
                            </li>
                        @endif

                        {{-- Pagination Elements - Show max 5 pages --}}
                        @php
                            $currentPage = $main_images->currentPage();
                            $lastPage = $main_images->lastPage();
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($lastPage, $startPage + 4);
                            
                            // Adjust start page if we're near the end
                            if ($endPage - $startPage < 4) {
                                $startPage = max(1, $endPage - 4);
                            }
                        @endphp

                        {{-- First page link if not in range --}}
                        @if ($startPage > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $main_images->url(1) }}">1</a>
                            </li>
                            @if ($startPage > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        {{-- Page number links (max 5 pages) --}}
                        @for ($page = $startPage; $page <= $endPage; $page++)
                            @if ($page == $currentPage)
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $main_images->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endfor

                        {{-- Last page link if not in range --}}
                        @if ($endPage < $lastPage)
                            @if ($endPage < $lastPage - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $main_images->url($lastPage) }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($main_images->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $main_images->nextPageUrl() }}" rel="next">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            
            {{-- Pagination Information --}}
            <div class="d-flex justify-content-center mt-3">
                <p class="text-muted">
                    Showing {{ $main_images->firstItem() }} to {{ $main_images->lastItem() }} of {{ $main_images->total() }} results
                </p>
            </div>
        </div>
    @endif
</div>

{{-- Alternative: Using Laravel's built-in pagination links --}}
{{-- You can also use this simpler approach: --}}
{{-- 
<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
    <div class="d-flex justify-content-center">
        {{ $main_images->links() }}
    </div>
</div>
--}}

{{-- Custom CSS for pagination styling (optional) --}}
<style>
.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    text-decoration: none;
}

.pagination .page-link:hover {
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
    cursor: not-allowed;
}

.pagination .page-item:first-child .page-link {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}

.pagination .page-item:last-child .page-link {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}
</style>
<div id="stickyBar" class="container">
    <center>
        <button id="submitImagesBtn" class="btn btn-primary">Submit</button>
    </center>
</div>


                 
<script>
                    
    const urlParams = new URLSearchParams(window.location.search);
    const mainCategory = urlParams.get('main_category');
    console.log('Main Category:', mainCategory);
            
                    
    $(document).ready(function () {
        // Handle checkbox selection
        $('.portfolio-design').hover(function () {
            $(this).find('.buttons-container').show();
        }, function () {
            $(this).find('.buttons-container').hide();
        });

        // Show sticky bar when image is selected
        $('.select-design-checkbox').change(function () {
            if ($('.select-design-checkbox:checked').length > 0) {
                $('#stickyBar').show();
            } else {
                $('#stickyBar').hide();
            }
        });

        // AJAX request to save selected images
        $('#submitImagesBtn').click(function (e) {
            e.preventDefault(); 
            var selectedImages = [];
            var selectedDesignData = [];
            var selectedDesignData1 = [];
            
            $('.select-design-checkbox:checked').each(function () {
                var checkbox = $(this);
                var designId = checkbox.val();

                // Method 1: If using data attributes approach
                if (checkbox.data('design')) {
                    // Option 2: JSON data attribute
                    var designData = checkbox.data('design');
                    
                    selectedImages.push(designData.id);
                    selectedDesignData.push({
                        id: designData.id,
                        main_img: checkbox.data('img-url'),
                        category: designData.cat,
                        sub_cate: designData.sub_cate,
                        img_url: checkbox.data('img-url'),
                        selected_at: new Date().toISOString()
                    });
                } 
            });
            var mainCategory_id=null;
            if(mainCategory){
                mainCategory_id=mainCategory;
            }
            

            
            // Include CSRF token
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route("user.productstoredesign") }}', // Use Laravel named route
                type: 'POST',
                data: {
                    _token: csrfToken, // Pass the CSRF token
                    designs: selectedImages,
                    selectedDesignData : selectedDesignData,
                    mainCategory_id : mainCategory_id,
                },
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        //response.count ||
                        // var dataToStore = {
                        //     newly_added: response.$newlyAdded,
                        //     recent_designs: response.recent_designs,
                        //     message: response.message,
                        //     count:  selectedImages.length,
                        //     timestamp: new Date().toISOString()
                        // };
                        
                        // // Store in sessionStorage
                        // try {
                        //     sessionStorage.setItem('recentlyAddedDesigns', JSON.stringify(dataToStore));
                        //     console.log('Data stored in sessionStorage', dataToStore);
                        // } catch (e) {
                        //     console.warn('SessionStorage full, storing minimal data');
                        //     // Fallback: store only essential data
                        //     sessionStorage.setItem('recentlyAddedDesigns', JSON.stringify({
                        //         count: dataToStore.count,
                        //         message: dataToStore.message,
                        //         recent_designs: dataToStore.recent_designs,
                        //     }));
                        // }
                        
                        window.location.href = '{{ route("user.catagory") }}';
                    }
                    
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Something went wrong. Please try again.');
                }
            });
        });
    });
</script>
@endsection
