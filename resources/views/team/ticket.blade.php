@extends('team.layout.navbar')
@section('content')
<style>
/* Custom style for the status dropdown */
.status-select {
    appearance: none; /* Remove default arrow in most browsers */
    -webkit-appearance: none; /* Safari/Chrome */
    -moz-appearance: none; /* Firefox */
    background: url("data:image/svg+xml,%3Csvg fill='gray' height='12' viewBox='0 0 24 24' width='12' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
    background-color: white;
    background-size: 12px;
    padding-right: 2rem; /* space for arrow */
    border: 1px solid #ccc;
    border-radius: 4px;
    height: 32px;
    font-size: 14px;
    cursor: pointer;
}
</style>
<div class="main-content">

    <div class="breadcrumb">
        <h1>Tickets</h1>
    </div>

    <!-- end of row-->
    <div class="row mb-4">

        <!-- end of col-->
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Tickets List</h4>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="comma_decimal_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Create Date</th>
                                    <th>Ticket No</th>
                                    <th>Client Name</th>
                                    <th>Priority</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{ date('Y-m-d', strtotime($ticket['create_date'])) }}</td>
                                    <td>{{ $ticket['id'] }}</td>
                                    <td>{{ $ticket['user']['name'] }}</td>
                                    <td>{{ $ticket['priority'] }}</td>
                                    <td>{{ $ticket['description'] }}</td>
                                    <td>
                                        <select class="form-control status-select" data-id="{{ $ticket['id'] }}">
                                            <option value="Pending" {{ $ticket['status'] == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Open" {{ $ticket['status'] == 'Open' ? 'selected' : '' }}>Open</option>
                                            <option value="In Progress" {{ $ticket['status'] == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="Resolved" {{ $ticket['status'] == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of col-->
    </div>
    <!-- end of row-->
    <!-- end of main-content -->
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selects = document.querySelectorAll('.status-select');

        selects.forEach(select => {
            select.addEventListener('change', function () {
                const id = this.getAttribute('data-id');
                const status = this.value;

                fetch(`ticket/{id}/update-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                            id: id,
                            status: status
                        })                  
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                        // alert('Status updated successfully.');
                    } else {
                        alert('Failed to update status.');
                    }
                })
                .catch(() => alert('Error while updating status.'));
            });
        });
    });
</script>

@endsection
