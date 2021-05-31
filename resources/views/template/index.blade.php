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
    <h4 class="page-title">Quản lý Template</h4>
</div>
<div class="col-sm-6">
    <div class="float-right">
        <a class="btn btn-success" href="javascript:void(0)" id="createNewTemplate"> Create New Template</a>
    </div>
</div>
@include('modals.template')
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
{{--                    <table class="table table-bordered data-table">--}}
                     <table class="table table-bordered dt-responsive nowrap data-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Tên Template</th>
                            <th>Version</th>
                            <th>Phân loại</th>
                            <th>Link CHPlay</th>
                            <th>script_copy | IMG | svg2xml</th>
                            <th>Thời gian tạo</th>
                            <th>Update</th>
                            <th>Time Get</th>
                            <th width="5%">Action</th>
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
<!-- Moment.js: -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/datetime-moment.js"></script>




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
            ajax: "{{ route('template.index') }}",
            columns: [
                {data: 'template'},
                {data: 'ver_build'},
                {data: 'category'},
                {data: 'link_chplay'},
                {data: 'script'},
                {data: 'time_create'},
                {data: 'time_update'},
                {data: 'time_get'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],

        });

        $('#createNewTemplate').click(function () {
            $('#saveBtn').val("create-template");
            $('#template_id').val('');
            $('#templateForm').trigger("reset");
            $('#modelHeading').html("Thêm mới Template");
            $('#ajaxModel').modal('show');
            $('.input_buildinfo_console').hide();
            $('.input_api').hide();
        });
        $('#templateForm').on('submit',function (event){
            event.preventDefault();
            if($('#saveBtn').val() == 'create-template'){
                $.ajax({
                    data: $('#templateForm').serialize(),
                    url: "{{ route('template.create') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        if(data.errors){
                            for( var count=0 ; count <data.errors.length; count++){
                                $("#templateForm").notify(
                                    data.errors[count],"error",
                                    { position:"right" }
                                );
                            }
                        }
                        if(data.success){
                            $.notify(data.success, "success");
                            $('#templateForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                        }
                    },
                });
            }
            if($('#saveBtn').val() == 'edit-template'){
                $.ajax({
                    data: $('#templateForm').serialize(),
                    url: "{{ route('template.update') }}",
                    type: "post",
                    dataType: 'json',
                    success: function (data) {
                        if(data.errors){
                            for( var count=0 ; count <data.errors.length; count++){
                                $("#templateForm").notify(
                                    data.errors[count],"error",
                                    { position:"right" }
                                );
                            }
                        }
                        if(data.success){
                            $.notify(data.success, "success");
                            $('#templateForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                        }
                    },
                });

            }

        });
        $(document).on('click','.editTemplate', function (data){
            var template_id = $(this).data('id');
            $('#modelHeading').html("Edit template");
            $('#saveBtn').val("edit-template");
            $('#ajaxModel').modal('show');

            $.ajax({
                data: $('#templateForm').serialize(),
                url: "{{ asset("template/edit") }}/" + template_id,
                type: "get",
                dataType: 'json',
                success: function (data) {
                    $('#template_id').val(data.id);
                    $('#template').val(data.template);
                    $('#ver_build').val(data.ver_build);
                    $('#script_copy').val(data.script_copy);
                    $('#script_img').val(data.script_img);
                    $('#script_svg2xml').val(data.script_svg2xml);
                    $('#note').val(data.note);
                    $('#link_chplay').val(data.link_chplay);
                    $('#category').val(data.category);

                }
            });

        });

        $(document).on('click','.deleteTemplate', function (data){
            var template_id = $(this).data("id");
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
                        url: "{{ asset("template/delete") }}/" + template_id,
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






