@extends('layouts.master')

@section('css')

<link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />



<!-- Sweet-Alert  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>



@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title">Quản lý Project</h4>
</div>
<div class="col-sm-6">
    <div class="float-right">
        <a class="btn btn-success" href="javascript:void(0)" id="createNewProject"> Create New Project</a>
    </div>
</div>
@include('modals.project')
@endsection
@section('content')
    <?php
    $message =Session::get('message');
    if($message){
        echo  '<span class="splash-message" style="color:#2a75f3">'.$message.'</span>';
        Session::put('message',null);
    }
    ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered data-table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Mã dự án</th>
                            <th>Tên Project</th>
                            <th>Tên Template</th>
                            <th>Tên Package</th>
                            <th>Tiêu đề</th>
                            <th>Trạng thái</th>

                            <th width="300px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
<!-- Required datatable js -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="plugins/datatables/dataTables.buttons.min.js"></script>
<script src="plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables/jszip.min.js"></script>
<script src="plugins/datatables/pdfmake.min.js"></script>
<script src="plugins/datatables/vfs_fonts.js"></script>
<script src="plugins/datatables/buttons.html5.min.js"></script>
<script src="plugins/datatables/buttons.print.min.js"></script>
<script src="plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="plugins/datatables/dataTables.responsive.min.js"></script>
<script src="plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="assets/pages/datatables.init.js"></script>


<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('project.index') }}",
            columns: [
                {data: 'projectid', name: 'projectid'},
                {data: 'ma_da', name: 'ma_da'},
                {data: 'projectname', name: 'projectname'},
                {data: 'template', name: 'template'},
                {data: 'package', name: 'package'},
                {data: 'title_app', name: 'title_app'},
                {
                    "data": "buildinfo_console",
                    "render" : function(data)
                    {
                        if (data==0) {
                            return '<span class="badge badge-dark">Mặc định</span>'
                        }if (data==1){
                            return '<span class="badge badge-success">Public</span>'
                        }if (data==2){
                        return '<span class="badge badge-info">Remove</span>'
                        }if (data==3){
                        return '<span class="badge badge-warning">Reject</span>'
                        }else {
                        return '<span class="badge badge-danger">Suspend</span>'
                        }
                    },

                    "name": "status", "autoWidth": true
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createNewProject').click(function () {
            $('#saveBtn').val("create-project");
            $('#project_id').val('');
            $('#projectForm').trigger("reset");
            $('#modelHeading').html("Thêm mới Project");
            $('#ajaxModel').modal('show');
            $('.input_buildinfo_console').hide();
            $('.input_api').hide();
        });
        $('#projectForm').on('submit',function (event){
            event.preventDefault();
            if($('#saveBtn').val() == 'create-project'){
                $.ajax({
                    data: $('#projectForm').serialize(),
                    url: "{{ route('project.create') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        if(data.errors){
                            for( var count=0 ; count <data.errors.length; count++){
                                $("#projectForm").notify(
                                    data.errors[count],"error",
                                    { position:"right" }
                                );
                            }
                        }
                        if(data.success){
                            $.notify(data.success, "success");
                            $('#projectForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                        }
                    },
                });
            }
            if($('#saveBtn').val() == 'edit-project'){
                $.ajax({
                    data: $('#projectForm').serialize(),
                    url: "{{ route('project.update') }}",
                    type: "post",
                    dataType: 'json',
                    success: function (data) {
                        if(data.errors){
                            for( var count=0 ; count <data.errors.length; count++){
                                $("#projectForm").notify(
                                    data.errors[count],"error",
                                    { position:"right" }
                                );
                            }
                        }
                        if(data.success){
                            $.notify(data.success, "success");
                            $('#projectForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                        }
                    },
                });

            }

        });
        $(document).on('click','.editProject', function (data){
            var project_id = $(this).data('id');
            $('#modelHeading').html("Edit Project");
            $('#saveBtn').val("edit-project");
            $('#ajaxModel').modal('show');
            $('.input_buildinfo_console').show();
            $('.input_api').show();

            $.ajax({
                data: $('#projectForm').serialize(),
                url: "{{ asset("project/edit") }}/" + project_id,
                type: "get",
                dataType: 'json',
                success: function (data) {
                    $('#project_id').val(data.projectid);
                    $('#projectname').val(data.projectname);
                    $('#template').val(data.template);
                    $('#ma_da').val(data.ma_da);
                    $('#package').val(data.package);
                    $('#title_app').val(data.title_app);
                    $('#buildinfo_link_policy_x').val(data.buildinfo_link_policy_x);
                    $('#buildinfo_link_fanpage').val(data.buildinfo_link_fanpage);
                    $('#buildinfo_link_website').val(data.buildinfo_link_website);
                    $('#buildinfo_link_store').val(data.buildinfo_link_store);
                    $('#buildinfo_app_name_x').val(data.buildinfo_app_name_x);
                    $('#buildinfo_store_name_x').val(data.buildinfo_store_name_x);
                    $('#buildinfo_vernum').val(data.buildinfo_vernum);
                    $('#buildinfo_verstr').val(data.buildinfo_verstr);
                    $('#buildinfo_keystore').val(data.buildinfo_keystore);
                    $('#buildinfo_console').val(data.buildinfo_console);
                    $('#ads_id').val(data.ads_id);
                    $('#banner').val(data.ads_banner);
                    $('#ads_inter').val(data.ads_inter);
                    $('#ads_reward').val(data.ads_reward);
                    $('#ads_native').val(data.ads_native);
                    $('#ads_open').val(data.ads_open);
                    $('#buildinfo_time').val(data.buildinfo_time);
                    $('#buildinfo_mess').val(data.buildinfo_mess);
                    $('#time_mess').val(data.time_mess);
                }
            });

        });
        $(document).on('click','.quickEditProject', function (data){
            var project_id = $(this).data('id');
            $('#modelHeading').html("Quick Edit Project");
            $('#saveQBtn').val("quick-edit-project");
            $('#ajaxQuickModel').modal('show');


            $.ajax({
                data: $('#projectQuickForm').serialize(),
                url: "{{ asset("project/edit") }}/" + project_id,
                type: "get",
                dataType: 'json',
                success: function (data) {
                    $('#quick_project_id').val(data.projectid);
                    $('#quick_projectname').val(data.projectname);
                    $('#quick_template').val(data.template);
                    $('#quick_ma_da').val(data.ma_da);
                    $('#quick_package').val(data.package);
                    $('#quick_title_app').val(data.title_app);
                    $('#quick_buildinfo_link_policy_x').val(data.buildinfo_link_policy_x);
                    $('#quick_buildinfo_link_fanpage').val(data.buildinfo_link_fanpage);
                    $('#quick_buildinfo_link_website').val(data.buildinfo_link_website);
                    $('#quick_buildinfo_link_store').val(data.buildinfo_link_store);
                    $('#quick_buildinfo_app_name_x').val(data.buildinfo_app_name_x);
                    $('#quick_buildinfo_store_name_x').val(data.buildinfo_store_name_x);
                    $('#quick_buildinfo_vernum').val(data.buildinfo_vernum);
                    $('#quick_buildinfo_verstr').val(data.buildinfo_verstr);
                    $('#quick_buildinfo_keystore').val(data.buildinfo_keystore);
                    $('#quick_buildinfo_console').val(data.buildinfo_console);
                    $('#quick_ads_id').val(data.ads_id);
                    $('#quick_banner').val(data.ads_banner);
                    $('#quick_ads_inter').val(data.ads_inter);
                    $('#quick_ads_reward').val(data.ads_reward);
                    $('#quick_ads_native').val(data.ads_native);
                    $('#quick_ads_open').val(data.ads_open);
                    $('#quick_buildinfo_time').val(data.buildinfo_time);
                    $('#quick_buildinfo_mess').val(data.buildinfo_mess);
                    $('#quick_time_mess').val(data.time_mess);
                }
            });

        });
        $('#projectQuickForm').on('submit',function (event){
            event.preventDefault();
            if($('#saveQBtn').val() == 'quick-edit-project'){
                $.ajax({
                    data: $('#projectQuickForm').serialize(),
                    url: "{{ route('project.update') }}",
                    type: "post",
                    dataType: 'json',
                    success: function (data) {
                        if(data.errors){
                            for( var count=0 ; count <data.errors.length; count++){
                                $("#projectForm").notify(
                                    data.errors[count],"error",
                                    { position:"right" }
                                );
                            }
                        }
                        if(data.success){
                            $.notify(data.success, "success");
                            $('#projectQuickForm').trigger("reset");
                            $('#ajaxQuickModel').modal('hide');
                            table.draw();
                        }
                    },
                });

            }

        });
        $(document).on('click','.deleteProject', function (data){
            var project_id = $(this).data("id");
            swal({
                    title: "Bạn có chắc muốn xóa?",
                    text: "Your will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Xác nhận xóa!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type: "get",
                        url: "{{ asset("project/delete") }}/" + project_id,
                        success: function (data) {
                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                    swal("Đã xóa!", "Your imaginary file has been deleted.", "success");
                });
        });
    });
</script>



@endsection


