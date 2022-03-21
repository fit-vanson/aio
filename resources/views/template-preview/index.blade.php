@extends('layouts.master')

@section('css')

<link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />




<!-- Sweet-Alert  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />


@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title">Template Preview</h4>
</div>
<div class="col-sm-6">
    <div class="float-right">
        <a class="btn btn-success" href="javascript:void(0)" id="createNewTemplatePreview"> Create New</a>
    </div>
</div>
@include('modals.template-preview')
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
{{--                    <table class="table table-bordered data-table">--}}
                     <table class="table table-bordered dt-responsive nowrap data-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th style="width: 250px">Logo</th>
                            <th>Template Preview</th>
                            <th>File</th>
                            <th>Category Template</th>
                            <th>Number</th>
                            <th>Action</th>
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
<script src="plugins/select2/js/select2.min.js"></script>
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
            displayLength: 50,
            ajax: {
                url: "{{ route('template-preview.getIndex') }}",
                type: "post"
            },
            columns: [
                {data: 'tp_logo'},
                {data: 'tp_name'},
                {data: 'tp_sc'},
                {data: 'tp_category'},
                {data: 'sum_script'},
                {data: 'action',className: "text-center", name: 'action', orderable: false, searchable: false},
            ],
            order:[1,'asc']

        });

        $('#createNewTemplatePreview').click(function () {
            $('#saveBtn').val("create-template-preview");
            $('#tp_id').val('');
            $("#category_template").val('');
            $("#category_template").select2({});
            $("#avatar").attr("src","img/demo_bn.png");
            $('#templatePreviewForm').trigger("reset");
            $('#modelHeading').html("Template Preview");
            $('#template_previewModel').modal('show');
        });
        $('#templatePreviewForm').on('submit',function (event){
            event.preventDefault();
            var formData = new FormData($("#templatePreviewForm")[0]);
            if($('#saveBtn').val() == 'create-template-preview'){
                $.ajax({
                    data: formData,
                    url: "{{ route('template-preview.create') }}",
                    type: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if(data.errors){
                            for( var count=0 ; count <data.errors.length; count++){
                                $("#templatePreviewForm").notify(
                                    data.errors[count],"error",
                                    { position:"right" }
                                );
                            }
                        }
                        if(data.success){
                            $.notify(data.success, "success");
                            $('#templatePreviewForm').trigger("reset");
                            $('#template_previewModel').modal('hide');
                            table.draw();
                        }
                    },
                });
            }
            if($('#saveBtn').val() == 'edit-template-preview'){
                $.ajax({
                    data: formData,
                    url: "{{ route('template-preview.update') }}",
                    type: "post",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if(data.errors){
                            for( var count=0 ; count <data.errors.length; count++){
                                $("#templatePreviewForm").notify(
                                    data.errors[count],"error",
                                    { position:"right" }
                                );
                            }
                        }
                        if(data.success){
                            $.notify(data.success, "success");
                            $('#templatePreviewForm').trigger("reset");
                            $('#template_previewModel').modal('hide');
                            table.draw();
                        }
                    },
                });
            }
        });
        $(document).on('click','.deleteTemplatePreview', function (data){
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
                        url: "{{ asset("template-preview/delete") }}/" + template_id,
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

<script>
    function editTemplatePreview(id) {
        $.get('{{asset('template-preview/edit')}}/'+id,function (data) {
            $('#tp_id').val(data.id);
            $("#avatar").attr("src",'file-manager/TemplatePreview/logo/'+data.tp_logo);
            $('#tp_name').val(data.tp_name);
            $('#tp_script_1').val(data.tp_script_1);
            $('#tp_script_2').val(data.tp_script_2);
            $('#tp_script_3').val(data.tp_script_3);
            $('#tp_script_4').val(data.tp_script_4);
            $('#tp_script_5').val(data.tp_script_5);
            $('#tp_script_6').val(data.tp_script_6);
            $('#tp_script_7').val(data.tp_script_7);
            $('#tp_script_8').val(data.tp_script_8);
            $('#category_template').val(data.tp_category);
            $("#category_template").select2({});


            if(data.tp_black !=0){
                $("#tp_black").prop('checked', true);
            }else{
                $("#tp_black").prop('checked', false);
            }

            if(data.tp_blue !=0){
                $("#tp_blue").prop('checked', true);
            }else{
                $("#tp_blue").prop('checked', false);
            }

            if(data.tp_while !=0){
                $("#tp_while").prop('checked', true);
            }else{
                $("#tp_while").prop('checked', false);
            }

            if(data.tp_pink !=0){
                $("#tp_pink").prop('checked', true);
            }else{
                $("#tp_pink").prop('checked', false);
            }

            if(data.tp_yellow !=0){
                $("#tp_yellow").prop('checked', true);
            }else{
                $("#tp_yellow").prop('checked', false);
            }

            $('#modelHeading').html("Edit");
            $('#saveBtn').val("edit-template-preview");
            $('#template_previewModel').modal('show');
            $('.modal').on('hidden.bs.modal', function (e) {
                $('body').addClass('modal-open');
            });
        })
    }

    $("#CategoryTemplateForm").submit(function (e) {
        e.preventDefault();
        let data = new FormData(document.getElementById('CategoryTemplateForm'));
        $.ajax({
            url:"{{route('category_template.create')}}",
            type: "post",
            data:data,
            processData: false,
            contentType: false,
            dataType: 'json',
            beForeSend : () => {
            },
            success:function (data) {
                console.log(data)
                if(data.errors){
                    for( var count=0 ; count <data.errors.length; count++){
                        $("#CategoryTemplateForm").notify(
                            data.errors[count],"error",
                            { position:"right" }
                        );
                    }
                }
                $.notify(data.success, "success");
                $('#CategoryTemplateForm').trigger("reset");
                $('#categoryTemplate').modal('hide');

                if(typeof data.cate_temp == 'undefined'){
                    data.cate_temp = {};
                }
                if(typeof rebuildCateTempOption == 'function'){
                    rebuildCateTempOption(data.cate_temp)
                }
            }
        });

    });
    function rebuildCateTempOption(cate_temp){
        var elementSelect = $("#category_template");

        if(elementSelect.length <= 0){
            return false;
        }
        elementSelect.empty();
        for(var item of cate_temp){
            elementSelect.append(
                $("<option></option>", {
                    value : item.id
                }).text(item.category_template_name)
            );
        }
    }
</script>
@endsection






