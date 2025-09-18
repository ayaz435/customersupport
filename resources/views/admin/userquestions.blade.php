@extends('admin.layout.navbar')
@section('content')
<div class="main-content">
    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="breadcrumb">
        <h1>User Questions</h1>
    </div>
    <div id="toastr-notifications" style="position: fixed; top: 0; right: 0; margin: 15px; z-index: 9999;">   <ul id="lateTeamMessagesList">
                        <!-- Existing messages will be displayed here -->
                    </ul></div>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h1>Late Replies Details</h1>


 <div>
    <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="comma_decimal_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Time</th>
                                        <th>Name</th>
                                        <th>Question</th>

                                    </tr>
                                </thead>
                                <tbody id="messages-list">
                                    @foreach($user_questions as $question)
                                        <tr>
                                            <td>{{ $question->id }}</td>
                                            <td>{{ $question->created_at }}</td>
                                            <td>{{ $question->name }}</td>

                                            <td>{{ $question->question }}</td>


                                            {{--  <td class="text-right">
                                                <a href="{{ route('admin.chats.del', $lateMessage->id) }}" class="btn btn-link btn-danger btn-just-icon remove">
                                                    <i class="material-icons">close</i>
                                                </a>
                                            </td>  --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Time</th>
                                        <th>Name</th>
                                        <th>Question</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
@endsection
