@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card">
                <div class="list-group text-center" id="list-panel">
                    <a href="{{url('dashboard')}}" class="list-group-item list-group-item-action" id="dashboard_panel"><i class="las la-home la-3x"></i>Dashboard</a>
                    <a href="{{url('dashboard/user/profile')}}" class="list-group-item list-group-item-action" id="profile_panel"><i class="las la-user-circle la-3x"></i>Profile</a>
                    <a href="{{url('dashboard/user/message')}}" class="list-group-item list-group-item-action" id="message_panel"><i class="las la-comment-alt la-3x"></i>Messages</a>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            @yield('konten')
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('#delete-data').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this item!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });

        if (window.location.href.indexOf("profile") > -1) {
            $("#dashboard_panel").removeClass('active');$("#profile_panel").addClass('active');
            $("#message_panel").removeClass('active');
        } else if (window.location.href.indexOf("message") > -1) {
            $("#dashboard_panel").removeClass('active');$("#profile_panel").removeClass('active');
            $("#message_panel").addClass('active')
        } else {
            $("#dashboard_panel").addClass('active');$("#profile_panel").removeClass('active');
            $("#message_panel").removeClass('active');
        }
    });
    
</script>
@endpush