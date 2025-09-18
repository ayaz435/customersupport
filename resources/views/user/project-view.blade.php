@extends('user.layout.navbar')
@section('content')
<!-- Bootstrap Bundle with Popper (Required for modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container">
    <!-- Display flash messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Product Links Verification</h4>
                    <button class="btn btn-primary btn-sm" onclick="location.reload()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
                <div class="card-body">
                    @if(count($data) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Link</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr id="row-{{ $item['id'] }}">
                                        <td>{{ $item['id'] }}</td>
                                        <td>
                                            <a href="{{ $item['link'] }}" target="_blank" class="text-primary">
                                                {{ Str::limit($item['link'], 50) }}
                                            </a>
                                        </td>
                                        <td>{{ $item['create_at'] }}</td>
                                        <td>
                                            @if($item['verify'] == 'Yes')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Verified
                                                </span>
                                                <small class="text-muted d-block">
                                                    {{ $item['verify_date'] }}
                                                </small>
                                            @elseif($item['verify'] == 'No')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle"></i> Declined
                                                </span>
                                                <small class="text-muted d-block">
                                                    {{ $item['verify_date'] }}
                                                </small>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item['verify'] == 'Yes')
                                                <span class="text-success">
                                                    <i class="fas fa-check"></i> Already Verified
                                                </span>
                                            @elseif($item['verify'] == 'No')
                                                {{--
                                                <span class="text-danger">
                                                    <i class="fas fa-times"></i> Declined
                                                </span>
                                                --}}
                                                <div class="btn-group" role="group">
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm verify-btn" 
                                                            data-id="{{ $item['id'] }}" 
                                                            data-project-id="{{ $item['pro_id'] }}" 
                                                            data-task-id="{{ $item['task_id'] }}" 
                                                            data-action="approve">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </div>
                                            @else
                                                <div class="btn-group" role="group">
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm verify-btn" 
                                                            data-id="{{ $item['id'] }}" 
                                                            data-project-id="{{ $item['pro_id'] }}" 
                                                            data-task-id="{{ $item['task_id'] }}" 
                                                            data-action="approve">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm verify-btn" 
                                                            data-id="{{ $item['id'] }}" 
                                                            data-project-id="{{ $item['pro_id'] }}" 
                                                            data-task-id="{{ $item['task_id'] }}" 
                                                            data-action="decline">
                                                        <i class="fas fa-times"></i> Decline
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No data available</h5>
                            <p class="text-muted">Unable to fetch data from the API or no records found.</p>
                            <button class="btn btn-primary" onclick="location.reload()">
                                <i class="fas fa-sync-alt"></i> Try Again
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fas fa-check-circle text-success"></i> Approve Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="itemDetails" class="form-label">Details (optional)<span class="text-danger"></span></label>
                    <textarea class="form-control" id="itemDetails" rows="4" 
                              placeholder="Please provide details for this action..."></textarea>
                    <div class="form-text">
                        Please explain the reason for this action (optional).
                    </div>
                </div>
                <div class="alert alert-info d-none" id="detailsAlert">
                    <i class="fas fa-info-circle"></i> <span id="alertMessage"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" id="confirmAction">
                    <i class="fas fa-check"></i> Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Processing request...</p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // CSRF token setup for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Variables to store current action data
    let currentItemId = null;
    let currentProjectId = null;
    let currentTaskId = null;
    let currentAction = null;
    let currentButton = null;
    

    // Handle verification buttons - show modal instead of direct AJAX
    $('.verify-btn').on('click', function() {
        currentButton = $(this);
        currentItemId = currentButton.data('id');
        currentProjectId = currentButton.data('project-id');
        currentTaskId = currentButton.data('task-id');
        currentAction = currentButton.data('action');
        
        // Clear previous details
        $('#itemDetails').val('');
        $('#detailsAlert').addClass('d-none');
        
        // Update modal title and button based on action
        if (currentAction === 'approve') {
            $('#modalTitle').html('<i class="fas fa-check-circle text-success"></i> Approve Item');
            $('#confirmAction').removeClass('btn-danger').addClass('btn-success').html('<i class="fas fa-check"></i> Approve');
            $('#alertMessage').text('This item will be marked as approved.');
        } else {
            $('#modalTitle').html('<i class="fas fa-times-circle text-danger"></i> Decline Item');
            $('#confirmAction').removeClass('btn-success').addClass('btn-danger').html('<i class="fas fa-times"></i> Decline');
            $('#alertMessage').text('This item will be marked as declined.');
        }
        
        // Show info alert
        $('#detailsAlert').removeClass('d-none');
        
        // Show the modal
        $('#detailsModal').modal('show');
    });

    // Handle confirm action button in modal
    $('#confirmAction').on('click', function() {
        const details = $('#itemDetails').val().trim();
        
        // Validate details
        // if (details.length < 10) {
        //     $('#itemDetails').addClass('is-invalid');
        //     showAlert('error', 'Please provide details (minimum 10 characters)');
        //     return;
        // }
        
        // Remove validation class
        $('#itemDetails').removeClass('is-invalid');
        
        // Hide details modal
        $('#detailsModal').modal('hide');
        
        // Show loading modal
        $('#loadingModal').modal('show');
        
        // Disable the original button and show loading
        currentButton.prop('disabled', true);
        currentButton.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        // Make AJAX request with details
        $.ajax({
            url: "{{ route('verify.item') }}",
            type: 'POST',
            data: {
                id: currentItemId,
                project_id : currentProjectId,
                task_id : currentTaskId,
                action: currentAction,
                details: details,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Hide loading modal
                $('#loadingModal').modal('hide');
                
                if (response.success) {
                    // Update the row
                    var row = $('#row-' + currentItemId);
                    
                    if (currentAction === 'approve') {
                        // Update status column
                        row.find('td:nth-child(4)').html(`
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                            <small class="text-muted d-block">
                                ${response.verify_date}
                            </small>
                        `);
                        
                        // Update actions column
                        row.find('td:nth-child(5)').html(`
                            <span class="text-success">
                                <i class="fas fa-check"></i> Already Verified
                            </span>
                            <div class="mt-1">
                                <small class="text-muted">
                                    <i class="fas fa-comment"></i> ${details.length > 50 ? details.substring(0, 50) + '...' : details}
                                </small>
                            </div>
                        `);
                        
                        // Show success message
                        showAlert('success', 'Item approved successfully!');
                    } else {
                        // For decline, update status and actions columns
                        row.find('td:nth-child(4)').html(`
                            <span class="badge bg-danger">
                                <i class="fas fa-times-circle"></i> Declined
                            </span>
                            <small class="text-muted d-block">
                                ${response.verify_date}
                            </small>
                        `);
                        
                        row.find('td:nth-child(5)').html(`
                            {{--
                            <span class="text-danger">
                                <i class="fas fa-times"></i> Declined
                            </span>
                            --}}
                            <div class="btn-group" role="group">
                                <button type="button" 
                                        class="btn btn-success btn-sm verify-btn" 
                                        data-id="${response.id}" 
                                        data-project-id="${response.pro_id}" 
                                        data-task-id="${response.task_id}" 
                                        data-action="approve">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            </div>
                            {{--
                            <div class="mt-1">
                                <small class="text-muted">
                                    <i class="fas fa-comment"></i> ${details.length > 50 ? details.substring(0, 50) + '...' : details}
                                </small>
                            </div>
                            --}}
                        `);
                        
                        showAlert('info', 'Item declined successfully!');
                    }
                } else {
                    showAlert('error', response.message || 'An error occurred');
                    // Re-enable button
                    resetButton(currentButton, currentAction);
                }
            },
            error: function(xhr, status, error) {
                // Hide loading modal
                $('#loadingModal').modal('hide');
                
                var errorMessage = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showAlert('error', errorMessage);
                
                // Re-enable button
                resetButton(currentButton, currentAction);
            }
        });
    });

    // Clear validation on textarea input
    $('#itemDetails').on('input', function() {
        $(this).removeClass('is-invalid');
    });

    // Handle modal close events
    $('#detailsModal').on('hidden.bs.modal', function() {
        $('#itemDetails').removeClass('is-invalid');
        $('#detailsAlert').addClass('d-none');
    });
    
    // Function to reset button state
    function resetButton(button, action) {
        button.prop('disabled', false);
        if (action === 'approve') {
            button.html('<i class="fas fa-check"></i> Approve');
        } else {
            button.html('<i class="fas fa-times"></i> Decline');
        }
    }
    
    // Function to show alerts
    function showAlert(type, message) {
        var alertClass = 'alert-success';
        var icon = 'fas fa-check-circle';
        
        if (type === 'error') {
            alertClass = 'alert-danger';
            icon = 'fas fa-exclamation-circle';
        } else if (type === 'info') {
            alertClass = 'alert-info';
            icon = 'fas fa-info-circle';
        }
        
        var alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="${icon}"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Remove existing alerts
        $('.alert').not('#detailsAlert').remove();
        
        // Add new alert at the top of the container
        $('.container').prepend(alertHtml);
        
        // Auto-hide alert after 5 seconds
        setTimeout(function() {
            $('.alert').not('#detailsAlert').fadeOut();
        }, 5000);
    }
});
</script>
@endsection

@section('styles')
<style>
    .table th {
        background-color: #343a40;
        color: white;
        font-weight: 600;
    }
    
    .btn-group .btn {
        margin-right: 5px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .badge {
        font-size: 0.8em;
    }
    
    .table-responsive {
        border-radius: 0.375rem;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .spinner-border {
        width: 3rem;
        height: 3rem;
    }
    
    /* Modal Styles */
    .modal-content {
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    
    .modal-title {
        font-weight: 600;
    }
    
    .modal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        border-radius: 0 0 0.5rem 0.5rem;
    }
    
    /* Textarea Styles */
    #itemDetails {
        resize: vertical;
        min-height: 100px;
    }
    
    #itemDetails.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    /* Alert Styles */
    .alert {
        border-radius: 0.375rem;
        border: none;
    }
    
    .alert-success {
        background-color: #d1edff;
        color: #0c5460;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    /* Button Animations */
    .btn {
        transition: all 0.15s ease-in-out;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    /* Loading Animation */
    .fa-spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Custom scrollbar for textarea */
    #itemDetails::-webkit-scrollbar {
        width: 8px;
    }
    
    #itemDetails::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    #itemDetails::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    
    #itemDetails::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection