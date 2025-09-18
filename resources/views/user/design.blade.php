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
    
</style>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Category Designs</h1>
        
        <?php
        if($missingData){
            ?>
            <span class="text-danger"><b class="text-danger">!Important missing file.</b> 
            -> <?php echo $missingData; ?>
            </span>  
        <?php } ?>
        
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-4">
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card mt-4">
                <div class="card-body" style="height:100vh; overflow-y: auto;">
                    <h3 class="card-title">All Categories</h3>
                    <div class="accordion" id="accordionRightIcon">
                        @foreach($mainCategories as $mainCategory)    
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a class="text-default collapsed main-category" data-toggle="collapse" href="#accordion-item-icon-right-{{ $mainCategory['id'] }}" aria-expanded="false" data-id="{{ $mainCategory['id'] }}">
                                            {{ $mainCategory['name'] }}
                                        </a>
                                    </h6>
                                </div>
                                <div class="collapse" id="accordion-item-icon-right-{{ $mainCategory['id'] }}" data-parent="#accordionRightIcon">
                                    <div class="card-body" id="subCategories">
                                    
                                   
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12">
            <div class="row " id="portfolioDesigns">
                <!-- Portfolio designs will be dynamically loaded here -->
            </div>
        </div>
    </div>
                                        <div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="fullImage">
   
</div>
</div>
    <div id="stickyBar" class="buttons-container" style="position: fixed; bottom: 0; left: 0; width: 100%; background-color: #fff; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.2); display: none;">
    <center>
    <textarea id="selectedDesignsTextArea" rows="4" name="selectedDesignsTextArea" cols="50" placeholder="Selected Designs"></textarea><br><button id="sendButton" onclick="sendSelectedDesigns()" style="background-color: #4bb750; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Send</button><center>
</div>
<script>
   let selectedDesigns = []; 
// Array to store selected designs
'${portfolioDesign.id}','${portfolioDesign.user_id}', '${portfolioDesign.category}', '${portfolioDesign.sub_cate}', '${portfolioDesign.sliders}', '${portfolioDesign.main_sliders}', '${portfolioDesign.status}'
function toggleSelection(checkbox, design_name, imgPath, design_id, drm_user_id, category_id, sub_category_id, sliders, main_sliders, status ) {
    if (checkbox.checked) {
        selectedDesigns.push({  design_name, imgPath, design_id, drm_user_id, category_id, sub_category_id, sliders, main_sliders, status });
    } else {
        selectedDesigns = selectedDesigns.filter(design => design.design_id !== design_id);
    }
    toggleStickyBar();
    updateSelectedDesignsTextArea();
}

function updateSelectedDesignsTextArea() {
    const selectedDesignsTextArea = document.getElementById('selectedDesignsTextArea');
    let text = '';
    selectedDesigns.forEach((design, index) => {
        text += `${index + 1}. ${design.design_name}\n`;
    });
    selectedDesignsTextArea.value = text;
}

    function toggleStickyBar() {
        const stickyBar = document.getElementById('stickyBar');
        if (selectedDesigns.length > 0) {
            stickyBar.style.display = 'block';
        } else {
            stickyBar.style.display = 'none';
        }
    }

   function sendSelectedDesigns() {
    // Get CSRF token value from the meta tag
   
    // Prepare data to send including CSRF token
    var dataToSend = {
       
        'images': selectedDesigns,
        'detail': $('#selectedDesignsTextArea').val()
    };
   console.log("Form Data:", dataToSend); 
    // Send AJAX request
    $.ajax({
        url: '{{ url("user/storedesign") }}',
        method: 'POST',
     data: JSON.stringify(dataToSend), 
    dataType: 'json',
    contentType: 'application/json; charset=utf-8',
    headers: {
      "Accept": "application/json",
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
    },
   
    
        success: function(response) {
            // Handle success response from the server
            console.log('Data sent successfully:', response);
            // Reset selectedDesigns array and textarea
            selectedDesigns = [];
            $('#selectedDesignsTextArea').val('');
            toggleStickyBar();
        },
        error: function(xhr, status, error) {
            // Handle error response from the server
            console.error('Error sending data:', error);
        }
    });
}



function submitDesigns() {
        const selectedDesignsTextArea = document.getElementById('selectedDesignsTextArea');
        const extraText = document.getElementById('extraText').value;
        let text = '';

        // Add selected designs to the textarea
        selectedDesigns.forEach((design, index) => {
            text += `${index + 1}. ${design.design_name}\n`;
        });

        // Add extra text
        text += `${extraText}\n`;

        // Update the textarea content
        selectedDesignsTextArea.value = text;

        // Reset selectedDesigns array and checkboxes
        selectedDesigns = [];
        document.querySelectorAll('.select-design-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
        toggleStickyBar();
    }
  // Add click event listener to main categories
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.main-category').forEach(function(category) {
        category.addEventListener('click', function() {
            var categoryId = this.getAttribute('data-id');
            fetchSubcategories(categoryId);
        });
    });
});

function fetchSubcategories(categoryId) {
    fetch(`https://webexcels.pk/api/portfolio-categories-sub/${categoryId}`)
        .then(response => response.json())
        .then(data => {
            var subCategoriesHTML = '';
            data.data.forEach(function(subCategory) {
                subCategoriesHTML += `<div class="sub-category" data-id="${subCategory.id}">${subCategory.name}</div>`;
            });
            document.getElementById('subCategories').innerHTML = subCategoriesHTML;

            // Add click event listener to sub categories
            document.querySelectorAll('.sub-category').forEach(function(subCategory) {
                subCategory.addEventListener('click', function() {
                    var subCategoryId = this.getAttribute('data-id');
                    fetchPortfolioDesigns(subCategoryId);
                });
            });
        })
        .catch(error => console.error('Error fetching subcategories:', error));
}

function fetchPortfolioDesigns(subCategoryId) {
    fetch(`https://webexcels.pk/api/portfolio-design`)
        .then(response => response.json())
        .then(data => {
            var portfolioDesignsHTML = '';
            data.data.forEach(function(portfolioDesign) {
                if (portfolioDesign.sub_cate === subCategoryId) {
                    portfolioDesignsHTML += `
                        <div class="col-lg-4 col-md-4 col-sm-12 mt-5 portfolio-design">
                            <div class="portfolio-design-img-container">
                                <img class="portfolio-design-img" src="${data.folderPath}/${portfolioDesign.main_img}" alt="${portfolioDesign.name}">
                            </div>
                            <div class="buttons-container">
                                <button class="view-full-design-btn mx-3" onclick="openModal('${data.folderPath}/${portfolioDesign.main_img}', '${portfolioDesign.name}')">View</button>
                 
                    <label> <b>Select</b></label>
                                {{--<input type="checkbox" class="select-design-checkbox" onchange="toggleSelection(this, '${portfolioDesign.design_name}', '${data.folderPath}/${portfolioDesign.main_img}')">--}}
                                <input type="checkbox" class="select-design-checkbox" onchange="toggleSelection(this, '${portfolioDesign.design_name}', '${data.folderPath}/${portfolioDesign.main_img}', '${portfolioDesign.id}','${portfolioDesign.user_id}', '${portfolioDesign.category}', '${portfolioDesign.sub_cate}', '${portfolioDesign.sliders}', '${portfolioDesign.main_sliders}', '${portfolioDesign.status}')">

                            </div>
                        </div>
                    `;
                }
            });
            document.getElementById('portfolioDesigns').innerHTML = portfolioDesignsHTML;
        })
        .catch(error => console.error('Error fetching portfolio designs:', error));
}

function openModal(imgSrc, imgAlt) {
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("fullImage");
    var captionText = document.getElementById("caption");
    modal.style.display = "block";
    modalImg.src = imgSrc;
    captionText.innerHTML = imgAlt;
}

// Close the Modal
document.addEventListener("DOMContentLoaded", function() {
    var closeBtn = document.querySelector(".close");
    closeBtn.addEventListener("click", function() {
        var modal = document.getElementById("imageModal");
        modal.style.display = "none";
    });

    // Add event listener to close the modal when clicking outside the modal content
    window.addEventListener("click", function(event) {
        var modal = document.getElementById("imageModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});

</script>
@endsection
