@extends('user.layout.navbar')
@section('content')
<!-- Bootstrap CSS (already likely included) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS and Popper.js (required for modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .active {
        background-color: #4bb750;

    }

    .custom-btn {
        font-size: 10px; /* Reduce font size */
        padding: 3px; /* Adjust padding for smaller size */
    }
    
    <style>
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgba(0,0,0,0.5); /* dim background */
    }
    
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 10px;
        width: 70%;
        max-width: 600px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        position: relative;
    }
    
    .close {
        color: #aaa;
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .close:hover {
        color: red;
    }
    
    /* Dropdown inside modal */
    .dropdown-container {
        position: relative;
    }
    
    .dropdown-container button {
        width: 80%;
        padding: 8px;
        background-color: #f1f1f1;
        border: 1px solid #ccc;
        cursor: pointer;
    }
    
    .dropdown-content {
        display: none;
        position: absolute;
        top: 105%;
        left: 0;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background-color: white;
        border: 1px solid #ccc;
        z-index: 2000;
        padding: 10px;
    }
    
    .category-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
</style>
<style>
    .modal {
        position: fixed;
        z-index: 9999;
        left: 0; top: 0;
        width: 100%; height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        position: relative;
    }

    .close {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 24px;
        cursor: pointer;
    }

    .subcategory-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px 20px;
        padding: 10px 0;
    }

    .subcategory-item {
        font-size: 14px;
    }
</style>
<style>
.category-section {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    margin-bottom: 32px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    transition: box-shadow 0.2s ease;
}

.category-section:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
}

.category-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
}

.category-icon {
    background: rgba(255, 255, 255, 0.2);
    padding: 12px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
    flex: 1;
}

.category-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.edit-category-btn {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.edit-category-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-1px);
}

.designs-section {
    padding: 20px;
}

.designs-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e2e8f0;
}

.designs-label {
    font-size: 1rem;
    font-weight: 600;
    color: #1a202c;
}

.add-design-btn {
    background: #667eea;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.add-design-btn:hover {
    background: #5a67d8;
    transform: translateY(-1px);
}

.add-design-btn.primary {
    background: #48bb78;
    padding: 12px 24px;
    font-size: 0.875rem;
    margin-top: 16px;
}

.add-design-btn.primary:hover {
    background: #38a169;
}

.subcategories-container {
    padding: 24px;
    display: grid;
    gap: 24px;
}

.subcategory-card {
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: all 0.2s ease;
}

.subcategory-card:hover {
    border-color: #cbd5e0;
    transform: translateY(-1px);
}

.subcategory-header {
    background: white;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid #e2e8f0;
}

.subcategory-icon {
    color: #667eea;
    display: flex;
    align-items: center;
}

.subcategory-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0;
    color: #1a202c;
    flex: 1;
}

.design-count {
    background: #e2e8f0;
    color: #4a5568;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.designs-grid {
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 16px;
}

.design-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.design-image-container {
    position: relative;
    aspect-ratio: 1;
    border-radius: 8px;
    overflow: hidden;
    background: #f1f5f9;
    border: 2px solid #e2e8f0;
    transition: all 0.2s ease;
}

.design-image-container:hover {
    border-color: #667eea;
    transform: scale(1.02);
}

.design-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.2s ease;
}

.design-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.design-image-container:hover .design-overlay {
    opacity: 1;
}

.view-btn {
    background: white;
    border: none;
    padding: 8px;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.1s ease;
}

.view-btn:hover {
    transform: scale(1.1);
}

.design-name {
    font-size: 0.875rem;
    font-weight: 500;
    color: #4a5568;
    text-align: center;
    line-height: 1.2;
}

.empty-state,
.empty-category {
    padding: 40px 20px;
    text-align: center;
    color: #64748b;
}

.empty-icon {
    color: #cbd5e0;
    margin-bottom: 16px;
    display: flex;
    justify-content: center;
}

.empty-text {
    font-size: 1rem;
    font-weight: 500;
    margin: 0 0 8px 0;
    color: #475569;
}

.empty-subtext {
    font-size: 0.875rem;
    margin: 0;
    color: #94a3b8;
}

.empty-category h4 {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0 0 8px 0;
    color: #475569;
}

.empty-category p {
    font-size: 0.875rem;
    margin: 0;
    color: #94a3b8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .category-header {
        padding: 20px 16px;
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .category-actions {
        width: 100%;
        justify-content: space-between;
    }
    
    .category-title {
        font-size: 1.25rem;
    }
    
    .subcategories-container {
        padding: 16px;
        gap: 16px;
    }
    
    .subcategory-header {
        padding: 16px;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .designs-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
    }
    
    .designs-section {
        padding: 16px;
    }
    
    .designs-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .modal-content {
        width: 95%;
        margin: 20px;
    }
    
    .modal-header {
        padding: 20px 20px 0 20px;
    }
    
    .modal-form {
        padding: 0 20px 20px 20px;
    }
}

@media (max-width: 480px) {
    .designs-grid {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
    }
}
</style>
<style>
    .dropdown-container {
        position: relative;
        display: inline-block;
        width: 250px;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        max-height: 300px;
        overflow-y: auto;
        width: 100%;
        border: 1px solid #ccc;
        z-index: 1;
    }

    .dropdown-container.open .dropdown-content {
        display: block;
    }

    .category-item {
        padding: 5px 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .selected-display {
        margin-bottom: 10px;
        padding: 8px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }

    .selected-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .selected-list li {
        padding: 6px;
        border-bottom: 1px solid #ccc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .send-btn {
        background-color: #007bff;
        color: white;
        padding: 3px 8px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
    }
</style>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Dashboard</h1> 
     
        <?php if($missingData){ ?>
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
        <div class="col-md-3 col-lg-3">
            <a href="{{ route('user.projectdetail') }}">
                <div class="card mb-4 o-hidden" data-route="user.projectdetail">
                    <div class="card-body ul-card__widget-chart">
                        <div class="ul-widget__chart-info">
                            <div class="ul-widget__chart-number">
                                <h2 class="t-font-boldest">Project</h2><small >see your projects progress >> click here</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-lg-3">
            <a href="{{ route('user.payment') }}">
                <div class="card mb-4 o-hidden" data-route="user.payment">
                    <div class="card-body ul-card__widget-chart">
                        <div class="ul-widget__chart-info">
                            <div class="ul-widget__chart-number">
                                <h2 class="t-font-boldest">Billing</h2><small >see your invoices >> click here</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-lg-3">
            <a href="{{ route('user.training') }}">
                <div class="card mb-4 o-hidden" data-route="user.training">
                    <div class="card-body ul-card__widget-chart">
                        <div class="ul-widget__chart-info">
                            <div class="ul-widget__chart-number">
                                <h2 class="t-font-boldest">Training</h2><small >professional training videos >> click here</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-lg-3">
            <a href="{{ route('user.complain') }}">
                <div class="card mb-4 o-hidden" data-route="user.complain">
                    <div class="card-body ul-card__widget-chart">
                        <div class="ul-widget__chart-info">
                            <div class="ul-widget__chart-number">
                                <h2 class="t-font-boldest">Ticket</h2><small >generate ticket in case of any delay >> click here</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>     
    </div>
</div>
<div class="main-content mt-5">
    <div class="breadcrumb">
        <h1>Send us Category Details</h1>
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
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                
                                <form action="{{ route('user.catagorystore') }}" id="comma_decimal" method="post">@csrf
                                    <div class="card-title my-3"> Add Catagories</div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="catagory_name">Main Catagory
                                            </label>
                                            <input class="form-control" id="catagory_name" name="catagory" type="text" placeholder="Main Catagory" />
                                            @error('catagory')
                                                <p class="invalid-feedback">{{ $message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="categoryDropdown">Select Sub-Categories Max-15
                                            </label><br>
                                            <!-- Dropdown component -->
                                            <div class="dropdown-container" id="categoryDropdown">
                                                <!--<button type="button" onclick="toggleDropdown()">Select Sub-Categories Max-15</button>-->
                                                <button type="button" class="btn btn-outline-secondary" onclick="openSubCategoryPopup()">Select Sub-Categories</button>
                                                <div class="dropdown-content" id="dropdownContent">
                                                    <div id="allCategories">
                                                        @foreach($subCategories['data'] as $item)
                                                            <div class="category-item" data-id="{{ $item['id'] }}">
                                                                <span>{{ $item['name'] }}</span>
                                                                <input type="checkbox" onchange="toggleCategory(this, '{{ $item['id'] }}', '{{ addslashes($item['name']) }}', '{{ $item['root_id'] }}' )"
                                                                {{ $selected_subCategories->pluck('category_id')->contains($item['id']) ? 'checked' : '' }}
                                                                     >
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <div id="selectedDisplay" class="selected-display">
                                                <strong>Selected Sub-Categories:</strong>
                                                <ul id="selectedList" class="selected-list">
                                                    @foreach($selected_subCategories as $item)
                                                        <hr class="mb-0">
                                                        <li data-id="{{ $item->id }}">
                                                            <h5>{{ $item->name }}</h5>
                                                        {{--    <button type="button" class="send-btn" onclick="sendAsProduct('{{ $item->category_id }}')">Select product</button>  --}}
                                                            <a href="{{ route('user.productdesign', ['id' => $item->category_id]) }}">
                                                                <button class="btn btn-primary px-5 "  type="button">Select Products</button>
                                                            </a>
                                                            <button type="button"
                                                                    data-id="{{ $item->category_id }}"
                                                                    data-main-category-id=""
                                                                    class="btn btn-success"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#uploadImageModal">
                                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                    <circle cx="12" cy="12" r="10"/>
                                                                    <line x1="12" y1="8" x2="12" y2="16"/>
                                                                    <line x1="8" y1="12" x2="16" y2="12"/>
                                                                </svg>
                                                                Upload Products
                                                            </button>
                                                        </li>
                                                        @php
                                                            $matchedDesigns = $selectedDesigns->where('category', $item->category_id);
                                                        @endphp
                                            
                                                        @if($matchedDesigns->isNotEmpty())
                                                            <div class="design-list mt-2">
                                                                <div class="row">
                                                                    @foreach($matchedDesigns as $design)
                                                                        <div class="col-md-3 col-sm-4 col-6 mt-2">
                                                                            <div class="card">
                                                                                <img src="{{ $design->img_url }}" class="card-img-top" alt="Design Image" style="height: 120px; object-fit: cover;">
                                                                                
                                                                                <div class="card-body p-2">
                                                                                   {{-- <small class="text-muted d-block">{{ $design->cname }}</small> --}}
                                                                                    <small class="text-muted">Design ID: {{ $design->design_id }}</small>
                                                                                    <div class="mt-2">
                                                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-design" 
                                                                                                data-design-id="{{ $design->id }}">
                                                                                            <i class="fas fa-trash-alt"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @else
                                                            <p class="text-muted mt-2">You haven\'t saved any product designs yet. Select some product designs to get started!.</p>
                                                        @endif
                                    
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        var allSelectedDesigns = @json($selectedDesigns); 
                                        let selectedItems = @json($selected_subCategories->map(function($item) {
                                            return ['id' => (string) $item->category_id, 'name' => $item->name,
                                            'root_id' => (string) $item->root_id];
                                        }));
                                        
                                        function toggleDropdown() {
                                            document.getElementById('categoryDropdown').classList.toggle('open');
                                        }
                                    
                                        function toggleCategory(checkbox, id, name,root_id) {
                                            if (checkbox.checked) {
                                                if (selectedItems.length >= 15) {
                                                    alert("You can only select up to 15 categories.");
                                                    checkbox.checked = false;
                                                    return;
                                                }
                                                sendToServer(id,name,root_id, true);
                                            } else {
                                                selectedItems = selectedItems.filter(item => item.id !== id);
                                                sendToServer(id,name,root_id, false);
                                            }
                                            // updateSelectedTop();
                                            updateSelectedDisplay();
                                        }
                                    
                                        function updateSelectedTop() {
                                            const selectedTop = document.getElementById('selectedTop');
                                            selectedTop.innerHTML = "";
                                            selectedItems.forEach(item => {
                                                const div = document.createElement('div');
                                                div.classList.add('category-item', 'selected-top');
                                                div.innerText = item.name;
                                                selectedTop.appendChild(div);
                                            });
                                        }
                                    
                                        function updateSelectedDisplay() {
                                            const selectedList = document.getElementById('selectedList');
                                            selectedList.innerHTML = "";                    
                                    
                                            selectedItems.forEach(item => {
                                                const hr = document.createElement('hr');
                                                hr.className = 'mb-0';
                                                selectedList.appendChild(hr);
                                                
                                                
                                                const li = document.createElement('li');
                                                li.innerHTML = `
                                                    <h4>${item.name}</h4>
                                                    <a href="/customersupport/user/productdesign?id=${item.id}">
                                                                    <button class="btn btn-primary px-5 "  type="button">Select Products</button></a>
                                                                    <button type="button"
                                                                            data-id="${item.id}"
                                                                            data-main-category-id=""
                                                                            class="btn btn-success"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#uploadImageModal">
                                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                            <circle cx="12" cy="12" r="10"/>
                                                                            <line x1="12" y1="8" x2="12" y2="16"/>
                                                                            <line x1="8" y1="12" x2="16" y2="12"/>
                                                                        </svg>
                                                                        Upload Products
                                                                    </button>
                                                `;
                                                selectedList.appendChild(li);
                                                
                                                const matchedDesigns = allSelectedDesigns.filter(design => design.category == item.id);
                                                console.log(matchedDesigns);
                                        
                                                const productsContainer = document.createElement('div');
                                                
                                                if (matchedDesigns.length > 0) {
                                                    productsContainer.innerHTML = `
                                                        <div class="design-list mt-2">
                                                            <div class="row">
                                                                ${matchedDesigns.map(design => `
                                                                    <div class="col-md-3 col-sm-4 col-6 mt-2 design-item-card">
                                                                        <div class="card">
                                                                            <img src="${design.img_url}" class="card-img-top" alt="Design Image" style="height: 120px; object-fit: cover;">
                                                                            <div class="card-body p-2">
                                                                                <small class="text-muted">Design ID: ${design.design_id}</small>
                                                                                <div class="mt-2">
                                                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-design" 
                                                                                            data-design-id="${design.id}">
                                                                                        <i class="fas fa-trash-alt"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                `).join('')}
                                                            </div>
                                                        </div>
                                                    `;
                                                } else {
                                                    productsContainer.innerHTML = '<p class="text-muted mt-2">You haven\'t saved any product designs yet. Select some product designs to get started!.</p>';
                                                }
                                                
                                                selectedList.appendChild(productsContainer);
                                    
                                            });
                                        }
                                    
                                    
                                        function sendToServer(id,name,root_id, isSelected) {
                                            var csrfToken = $('meta[name="csrf-token"]').attr('content');
                                    
                                            fetch('/customersupport/user/save-selected-category', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': csrfToken
                                                },
                                                body: JSON.stringify({ category_id: id, name: name, root_id: root_id, selected: isSelected })
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                console.log('Saved:', data);
                                                if(data.success && isSelected){
                                                    if (!selectedItems.find(item => item.id === id)) {
                                                        selectedItems.push({ id, name });
                                                        // updateSelectedTop();
                                                        updateSelectedDisplay();
                                                    }             
                                                }else if(!data.success){
                                                    alert(data.error);
                                                }
                                    
                                            })
                                            .catch(err => {
                                                console.error(err);
                                                alert("error");
                                                });
                                        }
                                    
                                        function sendAsProduct(id) {
                                            var csrfToken = $('meta[name="csrf-token"]').attr('content');
                                    
                                            fetch(`/customersupport/user/productdesign?id=${id}`, {
                                                method: 'GET',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': csrfToken
                                                },
                                                // body: JSON.stringify({ category_id: id })
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                alert("Product sent successfully.");
                                            })
                                            .catch(err => console.error(err));
                                        }
                                    </script>
                                    
                                     <div class="col-md-12">
                                        <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                    </div>
                                </form>
                                <br><br>
                                
                                
                                
                                @foreach($submitted_categories as $category)
                                    <div class="category-section">
                                        <div class="category-header">
                                            <div class="category-icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                                                </svg>
                                            </div>
                                            <h2 class="category-title">{{ $category->name }}</h2>
                                            <div class="category-actions">
                                                <div class="category-count">
                                                    {{ $category->subCategories->count() }} {{ Str::plural('subcategory', $category->subCategories->count()) }}
                                                </div>
                                                <button class="edit-category-btn" 
                                                        onclick="openEditCategoryModal(this)"
                                                        data-category-id="{{ $category->id }}"
                                                        data-category-name="{{ $category->name }}"
                                                        data-subcategories='@json($category->subCategories)'
                                                        {{--data-subcategories="{{ json_encode($category->subCategories->pluck('id')->toArray()) }}">--}}
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                    </svg>
                                                    Edit
                                                </button>
                                            </div>
                                        </div>
                                
                                        @if($category->subCategories->isNotEmpty())
                                            <div class="subcategories-container">
                                                @foreach($category->subCategories as $sub)
                                                    <div class="subcategory-card">
                                                        <div class="subcategory-header">
                                                            <div class="subcategory-icon">
                                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                    <path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z"/>
                                                                    <path d="M8 5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2H8V5z"/>
                                                                </svg>
                                                            </div>
                                                            <h3 class="subcategory-title">{{ $sub->name }}</h3>
                                                            <span class="design-count">{{ $sub->productDesigns->count() }} Products</span>
                                                        </div>
                                
                                                        @if($sub->productDesigns->isNotEmpty())
                                                            <div class="designs-section">
                                                                <div class="designs-header">
                                                                    <span class="designs-label">Products</span>
                                                                    <a href="{{ route('user.productdesign', ['id' => $sub->category_id, 'main_category' => $sub->main_category_id]) }}">
                                                                        <button class="add-design-btn">
                                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                                <circle cx="12" cy="12" r="10"/>
                                                                                <line x1="12" y1="8" x2="12" y2="16"/>
                                                                                <line x1="8" y1="12" x2="16" y2="12"/>
                                                                            </svg>
                                                                            Add Product
                                                                        </button>
                                                                    </a>
                                                                    <button type="button"
                                                                            data-id="{{ $sub->category_id }}"
                                                                            data-main-category-id="{{ $sub->main_category_id }}"
                                                                            class="btn btn-success"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#uploadImageModal">
                                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                            <circle cx="12" cy="12" r="10"/>
                                                                            <line x1="12" y1="8" x2="12" y2="16"/>
                                                                            <line x1="8" y1="12" x2="16" y2="12"/>
                                                                        </svg>
                                                                        Upload Products
                                                                    </button>
                                                                </div>
                                                                <div class="designs-grid">
                                                                    @foreach($sub->productDesigns as $design)
                                                                        <div class="design-item">
                                                                            <div class="design-image-container">
                                                                                <img src="{{ $design->img_url }}" 
                                                                                     alt="Design: {{ $design->name ?? 'Product Design' }}"
                                                                                     class="design-image"
                                                                                     loading="lazy"
                                                                                     onerror="this.onerror=null;this.src='/placeholder.png';">
                                                                                <div class="design-overlay">
                                                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-design" 
                                                                                            data-design-id="{{ $design->id }}">
                                                                                        <i class="fas fa-trash-alt"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                            @if(isset($design->name))
                                                                                <div class="design-name">{{ Str::limit($design->name, 15) }}</div>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="empty-state">
                                                                <div class="empty-icon">
                                                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                                                        <circle cx="9" cy="9" r="2"/>
                                                                        <path d="M21 15l-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                                                    </svg>
                                                                </div>
                                                                <p class="empty-text">No products available</p>
                                                                <p class="empty-subtext">Click below to add your first Product</p>
                                                                <a href="{{ route('user.productdesign', ['id' => $sub->category_id, 'main_category' => $sub->main_category_id]) }}">
                                                                    <button class="add-design-btn primary">
                                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                            <circle cx="12" cy="12" r="10"/>
                                                                            <line x1="12" y1="8" x2="12" y2="16"/>
                                                                            <line x1="8" y1="12" x2="16" y2="12"/>
                                                                        </svg>
                                                                        Add Products
                                                                    </button>
                                                                </a>
                                                                <button type="button"
                                                                        data-id="{{ $sub->category_id }}"
                                                                        data-main-category-id="{{ $sub->main_category_id }}"
                                                                        class="btn btn-success"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#uploadImageModal">
                                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                        <circle cx="12" cy="12" r="10"/>
                                                                        <line x1="12" y1="8" x2="12" y2="16"/>
                                                                        <line x1="8" y1="12" x2="16" y2="12"/>
                                                                    </svg>
                                                                    Upload Products
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="empty-category">
                                                <div class="empty-icon">
                                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                                                        <path d="M12 11v6"/>
                                                        <path d="M9 14h6"/>
                                                    </svg>
                                                </div>
                                                <h4>No subcategories yet</h4>
                                                <p>This category is ready for subcategories to be added</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Upload Product Image Modal -->
<div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('product.image.upload') }}" enctype="multipart/form-data">
      @csrf
      <!-- Hidden inputs to receive values from button -->
      <input type="hidden" name="category_id" id="hiddenCategoryId">
      <input type="hidden" name="main_category_id" id="hiddenMainCategoryId">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadImageModalLabel">Upload Product Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
          <div class="mb-3">
            <label for="productImage" class="form-label">Choose Image</label>
            <input class="form-control" type="file" name="product_image" id="productImage" accept="image/*" required>
            @error('product_image')
              <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Upload</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const uploadButtons = document.querySelectorAll('[data-bs-target="#uploadImageModal"]');

        uploadButtons.forEach(button => {
            button.addEventListener('click', function () {
                const categoryId = this.getAttribute('data-id');
                const mainCategoryId = this.getAttribute('data-main-category-id');

                document.getElementById('hiddenCategoryId').value = categoryId;
                document.getElementById('hiddenMainCategoryId').value = mainCategoryId;
            });
        });
    });
</script>

<div id="editCategoryModal" class="modal" style="display:none;">
    <div class="modal-content" style="max-width: 1000px;">
        <span class="close" onclick="closeEditCategoryModal()">&times;</span>
        <div class="m-3">
        <!-- Form -->
        <form action="{{ route('user.update.main.category') }}" id="comma_decimal" method="post">
            @csrf
            <input type="hidden" name="main_category_id" id="main_category_id" />

            <div class="card-title my-3">Edit Category</div>
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label>Main Category</label>
                    <input class="form-control" id="edit_category_name" name="catagory" type="text" placeholder="Main Category" />
                </div>
                <div class="col-md-6 form-group mb-3"></div>

                <div class="col-md-12 mb-3">
                    <label>Select Sub-Categories Max-15</label>
                    
                    <div class="form-group mb-3">
                        <input type="text" id="subcategorySearch1" class="form-control" placeholder="Search Sub-Category (Exact match)">
                    </div>
                    
                    <div class="subcategory-grid m-2" id="subcategory-container">
                        @foreach($subCategories['data'] as $item)
                            <div class="subcategory-item">
                                <label>
                                    <input type="checkbox"  class="form-check-input edit-subcategory-checkbox"
                                                id="edit_sub_{{ $item['id'] }}"
                                                data-sub-id="{{ $item['id'] }}"
                                                name="subcategories[]"
                                                value="{{ $item['id'] }}"
                                                data-name="{{ $item['name'] }}"
                                                data-root-id="{{ $item['root_id'] }}"
                                    onchange="editSubCategoryToggle(this, '{{ $item['id'] }}', '{{ addslashes($item['name']) }}', '{{ $item['root_id'] }}' )"
                                            >
                                    {{ $item['name'] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <button class="btn btn-primary" name="submit" type="submit">Update</button>
            </div>
        </form>
        </div>
    </div>
</div>


<script>
document.getElementById('subcategorySearch1').addEventListener('input', function () {
    const query = this.value.trim().toLowerCase();
    const items = document.querySelectorAll('#subcategory-container .subcategory-item');

    items.forEach(item => {
        const label = item.textContent.trim().toLowerCase();
        if (label.includes(query)) {
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    });
});
</script>

<div id="subCategoryPopupModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 1000px;">
        <span class="close" onclick="closeSubCategoryPopup()">&times;</span>
        <h5>Select Sub-Categories (Max 15)</h5>
        
        <!-- Search Bar -->
            <div class="search-container">
                <input type="text" 
                       id="subcategorySearch" 
                       class="search-input" 
                       placeholder="Search subcategories..." 
                       onkeyup="searchSubcategories()">
            </div>

        <div class="subcategory-grid" id="subcategoryGrid">
            @foreach($subCategories['data'] as $item)
                <div class="subcategory-item">
                    <label>
                        <input type="checkbox" onchange="toggleCategory(this, '{{ $item['id'] }}', '{{ addslashes($item['name']) }}', '{{ $item['root_id'] }}' )"
                                {{ $selected_subCategories->pluck('category_id')->contains($item['id']) ? 'checked' : '' }}  >
                        {{ $item['name'] }}
                    </label>
                </div>
            @endforeach
        </div>
        <script>
        function searchSubcategories() {
            const searchTerm = document.getElementById('subcategorySearch').value.toLowerCase();
            const subcategoryItems = document.querySelectorAll('.subcategory-item');
            let visibleCount = 0;
            
            subcategoryItems.forEach(item => {
                const label = item.querySelector('label');
                const categoryName = label.textContent.trim().toLowerCase();
                
                if (categoryName.includes(searchTerm)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide "no results" message
            const grid = document.getElementById('subcategoryGrid');
            let noResultsMsg = document.getElementById('noResultsMessage');
            
            if (visibleCount === 0 && searchTerm.length > 0) {
                if (!noResultsMsg) {
                    noResultsMsg = document.createElement('div');
                    noResultsMsg.id = 'noResultsMessage';
                    noResultsMsg.className = 'no-results';
                    noResultsMsg.textContent = 'No subcategories found matching your search.';
                    grid.appendChild(noResultsMsg);
                }
                noResultsMsg.style.display = 'block';
            } else {
                if (noResultsMsg) {
                    noResultsMsg.style.display = 'none';
                }
            }
        }
        </script>

        <div class="text-end mt-3">
            <button type="button" class="btn btn-primary" onclick="closeSubCategoryPopup()">Done</button>
        </div>
    </div>
</div>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputField = document.getElementById('catagory_name');
            const storageKey = 'mainCategoryInput';
    
            // Load saved value if it exists
            if (localStorage.getItem(storageKey)) {
                inputField.value = localStorage.getItem(storageKey);
            }
    
            // Save input on change
            inputField.addEventListener('input', function () {
                localStorage.setItem(storageKey, inputField.value);
            });
    
            // Clear the stored value on form submit
            const form = document.getElementById('comma_decimal');
            form.addEventListener('submit', function () {
                localStorage.removeItem(storageKey);
            });
        });
    </script>
<script>
    let editSelectedItems = [];

    function openSubCategoryPopup() {
        document.getElementById('subCategoryPopupModal').style.display = 'block';
    }

    function closeSubCategoryPopup() {
        document.getElementById('subCategoryPopupModal').style.display = 'none';
    }

    function toggleEditSubCategory(checkbox) {
        const id = checkbox.getAttribute('data-sub-id');
        const name = checkbox.parentElement.textContent.trim();

        if (checkbox.checked) {
            if (editSelectedItems.length >= 15) {
                alert("You can only select up to 15 sub-categories.");
                checkbox.checked = false;
                return;
            }

            if (!editSelectedItems.find(item => item.id === id)) {
                editSelectedItems.push({ id, name });
            }
        } else {
            editSelectedItems = editSelectedItems.filter(item => item.id !== id);
        }
    }
</script>
<script>
    function editSubCategoryToggle(isSelected,id,name,root_id ) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        const payload = {
            category_id: id,
            name: name,
            root_id: root_id,
            selected: isSelected.checked,
            main_category_id: isSelected.getAttribute('data-main-category-id'),
        };

        fetch('/customersupport/user/edit-selected-category', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            console.log('Saved:', data);
            if(data.success && isSelected){
                if (!selectedItems.find(item => item.id === id)) {
                    selectedItems.push({ id, name });
                    // updateSelectedTop();
                    updateSelectedDisplay();
                }             
            }else if(!data.success){
                alert(data.error);
            }

        })
        .catch(err => {
            console.error(err);
            alert("error");
            });
    }

function openEditCategoryModal(button) {
    // Show the modal
    document.getElementById('editCategoryModal').style.display = 'block';

    // Get data attributes from button
    const categoryId = button.getAttribute('data-category-id');
    const categoryName = button.getAttribute('data-category-name');
    const subcategories = JSON.parse(button.getAttribute('data-subcategories'));
    console.log(subcategories);
    console.log(categoryId);
    

    // Populate the modal fields
    const idField = document.getElementById('main_category_id');
    if (idField) {
        idField.value = categoryId;
    } else {
        console.error('edit_category_id input not found!');
    }
    document.getElementById('edit_category_name').value = categoryName;

    // Uncheck all checkboxes first
    document.querySelectorAll('.edit-subcategory-checkbox').forEach(checkbox => {
        checkbox.checked = false;
        checkbox.setAttribute('data-main-category-id', categoryId); 
    });

    // Check checkboxes for existing subcategories
    subcategories.forEach(subcategory => {
        const checkbox = document.querySelector(`.edit-subcategory-checkbox[data-sub-id='${subcategory.category_id}']`);
        if (checkbox) checkbox.checked = true;
    });
}

function closeEditCategoryModal() {
    document.getElementById('editCategoryModal').style.display = 'none';
}

function toggleEditDropdown() {
    const dropdown = document.getElementById('editDropdownContent');
    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
}

function toggleEditSubCategory(checkbox) {
    // Optional: enforce max 15 selections
    const selected = document.querySelectorAll('.edit-subcategory-checkbox:checked');
    if (selected.length > 15) {
        checkbox.checked = false;
        alert("You can select up to 15 sub-categories only.");
    }
}
</script>
<script>
    var maxInputs = 10; // Set the maximum number of inputs allowed
    var currentInputCount = 0; // Initialize the current input count

    // Function to add a new input element
    function addInput() {
        if (currentInputCount < maxInputs) {
            // Create a new input element
            var input = document.createElement("input");
            input.type = "text"; // You can change the input type as needed
            input.name = "subcatagory[]"; // Set a name attribute if needed
            input.classList.add("input", "form-control")
            var br = document.createElement("br");
            // Get the container where you want to append the input
            var container = document.getElementById("inputContainer");

            // Append the input element to the container
            container.appendChild(input);
            container.appendChild(br);

            // Increment the input count
            currentInputCount++;
        } else {
            alert("You've reached the maximum limit of inputs (10).");
        }
    }

    // Get the button element
    var addButton = document.getElementById("addInputButton");

    // Add a click event listener to the button
    addButton.addEventListener("click", addInput);
</script>
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
<script>
    function displayRecentlyAddedDesigns() {
    var storedData = sessionStorage.getItem('recentlyAddedDesigns');
    console.log( storedData);

}

// Call this function when the back page loads
$(document).ready(function() {
    displayRecentlyAddedDesigns();
    
    $(document).on('click', '.remove-design', function (e) {
        e.preventDefault(); 
        var selectedImages = [];
        var button = $(this);
        var designId = button.data('design-id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '{{ route("user.category.delete") }}', 
            type: 'POST',
            data: {
                _token: csrfToken, 
                designId: designId,
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    
                    allSelectedDesigns = allSelectedDesigns.filter(design => design.id != designId);
                    updateSelectedDisplay();
                    button.closest('.design-item-card').remove();
                    button.closest('.design-item').remove();

                    alert('Design removed successfully');
                } else {
                    alert('Unable to delete. Please try again');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    
});

window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
        displayRecentlyAddedDesigns();
    }
});

</script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // 1. Initialize Pusher
    const pusher = new Pusher('95fea33118d4843b9abf=', {
        cluster: 'ap2',
        authEndpoint: '/broadcasting/auth', // your backend endpoint
        auth: {
            headers: {
                Authorization: 'Bearer '. csrfToken
            }
        }
    });

    // 2. Connect to Pusher and log socket_id
    pusher.connection.bind('connected', function () {
        console.log("Socket ID:", pusher.connection.socket_id); // This is what you send to server
    });

    // 3. Subscribe to a private channel (this triggers auth request)
    const channel = pusher.subscribe('private-chat.1');
</script>
@endsection
