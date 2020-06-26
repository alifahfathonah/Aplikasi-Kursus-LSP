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
                    <a href="{{url('dashboard/admin/profile')}}" class="list-group-item list-group-item-action" id="profile_panel"><i class="las la-user-circle la-3x"></i>Profile</a>
                    <a href="{{url('dashboard/admin/manage')}}" class="list-group-item list-group-item-action" id="manage_panel"><i class="las la-user-friends la-3x"></i>Manage User</a>
                    <a href="{{url('dashboard/admin/asset')}}" class="list-group-item list-group-item-action" id="asset_panel"><i class="las la-poll-h la-3x"></i>Asset</a>
                    <a href="{{url('dashboard/admin/blog')}}" class="list-group-item list-group-item-action" id="blog_panel"><i class="las la-blog la-3x"></i>Blog</a>
                    <a href="{{url('dashboard/admin/document')}}" class="list-group-item list-group-item-action" id="document_panel"><i class="las la-camera la-3x"></i>Documentation</a>
                    <a href="{{url('dashboard/admin/message')}}" class="list-group-item list-group-item-action" id="message_panel"><i class="las la-comment-alt la-3x"></i>Messages</a>
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
<script src="https://cdn.tiny.cloud/1/m8ktaya7l3j3nph0hhz75i76ejm65m6xanq7h33eb3h9iiai/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#konten',
        statusbar: true,
        menubar: true,
        force_br_newlines : true,
        force_p_newlines : false,
        plugins: "link",
        
    });

    tinymce.init({
        selector: '#deskripsi',
        statusbar: true,
        menubar: true,
        force_br_newlines : true,
        force_p_newlines : false,
        plugins: "link",
        
    });

    tinymce.init({
        selector: '#deskripsi-read',
        statusbar: true,
        menubar: true,
        readonly: 1,
        force_br_newlines : true,
        force_p_newlines : false,
        plugins: "link",
        
    });
</script>

<script type="text/javascript">
    function deleteImageBlog(id, namafile, myparent) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this image!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.post("{{url('dashboard/admin/blog/deleteImage')}}", {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        id: id,
                        namafile: namafile,

                    }, function(resp) {
                        if (resp == 'ok') {
                            $('#' + myparent).remove();
                            swal("Poof! Your image file has been deleted!", {
                                icon: "success",
                            });
                        } else {
                            swal("Whoops, There were some problems");
                        }
                    });
                }
            });
    }

    function deleteImageAsset(id, namafile, myparent) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this image!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.post("{{url('dashboard/admin/asset/deleteImage')}}", {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        id: id,
                        namafile: namafile,

                    }, function(resp) {
                        if (resp == 'ok') {
                            $('#' + myparent).remove();
                            swal("Poof! Your image file has been deleted!", {
                                icon: "success",
                            });
                        } else {
                            swal("Whoops, There were some problems");
                        }
                    });
                }
            });
    }

    function deleteImageDoc(id, namafile, myparent) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this image!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.post("{{url('dashboard/admin/document/deleteImage')}}", {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        id: id,
                        namafile: namafile,

                    }, function(resp) {
                        if (resp == 'ok') {
                            $('#' + myparent).remove();
                            swal("Poof! Your image file has been deleted!", {
                                icon: "success",
                            });
                        } else {
                            swal("Whoops, There were some problems");
                        }
                    });
                }
            });
    }

    function deleteVideo(id, namafile, myparent) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this video!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.post("{{url('dashboard/admin/document/deleteVideo')}}", {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        id: id,
                        namafile: namafile,

                    }, function(resp) {
                        if (resp == 'ok') {
                            $('#' + myparent).remove();
                            swal("Poof! Your video has been deleted!", {
                                icon: "success",
                            });
                        } else {
                            swal("Whoops, There were some problems");
                        }
                    });
                }
            });
    }

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

        $("select#provinsi").change(function() {
            var selectedProvince = $("#provinsi option:selected").val();
            var parentCity = document.getElementById("listKota");
            while (parentCity.firstChild) {
                parentCity.removeChild(parentCity.lastChild);
            }
            $.post("{{url('dashboard/admin/asset/getCities')}}", {
                '_token': $('meta[name=csrf-token]').attr('content'),
                province: selectedProvince,

            }, function(resp) {
                var lab = $('<label for="kota">Kota</label>').appendTo('#listKota');
                var sel = $('<select name="kota" class="selectpicker form-control" data-live-search="true" id="kota">').appendTo('#listKota');
                $(resp).each(function() {
                    sel.append($("<option>").attr('value', this.id).text(this.kota));
                });
            });
        });

        if (window.location.href.indexOf("asset") > -1) {
            $("#dashboard_panel").removeClass('active');
            $("#profile_panel").removeClass('active');
            $("#manage_panel").removeClass('active');
            $("#asset_panel").addClass('active');
            $("#blog_panel").removeClass('active');
            $("#document_panel").removeClass('active');
            $("#message_panel").removeClass('active')
        } else if (window.location.href.indexOf("profile") > -1) {
            $("#dashboard_panel").removeClass('active');
            $("#profile_panel").addClass('active');
            $("#manage_panel").removeClass('active');
            $("#asset_panel").removeClass('active');
            $("#blog_panel").removeClass('active');
            $("#document_panel").removeClass('active');
            $("#message_panel").removeClass('active')
        } else if (window.location.href.indexOf("manage") > -1) {
            $("#dashboard_panel").removeClass('active');
            $("#profile_panel").removeClass('active');
            $("#manage_panel").addClass('active');
            $("#asset_panel").removeClass('active');
            $("#blog_panel").removeClass('active');
            $("#document_panel").removeClass('active');
            $("#message_panel").removeClass('active')
        } else if (window.location.href.indexOf("blog") > -1) {
            $("#dashboard_panel").removeClass('active');
            $("#profile_panel").removeClass('active');
            $("#manage_panel").removeClass('active');
            $("#asset_panel").removeClass('active');
            $("#blog_panel").addClass('active');
            $("#document_panel").removeClass('active');
            $("#message_panel").removeClass('active')
        } else if (window.location.href.indexOf("document") > -1) {
            $("#dashboard_panel").removeClass('active');
            $("#profile_panel").removeClass('active');
            $("#manage_panel").removeClass('active');
            $("#asset_panel").removeClass('active');
            $("#blog_panel").removeClass('active');
            $("#document_panel").addClass('active');
            $("#message_panel").removeClass('active')
        } else if (window.location.href.indexOf("message") > -1) {
            $("#dashboard_panel").removeClass('active');
            $("#profile_panel").removeClass('active');
            $("#manage_panel").removeClass('active');
            $("#asset_panel").removeClass('active');
            $("#blog_panel").removeClass('active');
            $("#document_panel").removeClass('active');
            $("#message_panel").addClass('active')
        } else {
            $("#dashboard_panel").addClass('active');
            $("#profile_panel").removeClass('active');
            $("#manage_panel").removeClass('active');
            $("#asset_panel").removeClass('active');
            $("#blog_panel").removeClass('active');
            $("#document_panel").removeClass('active');
            $("#message_panel").removeClass('active')
        }
    });
</script>
@endpush