@extends('layouts.master')

@section('css')

<link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Sweet-Alert  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<!-- Select2 Js  -->
<link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />


@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title">Quản lý Project2</h4>
</div>
<div class="col-sm-6">
    <div class="float-right">
        <a class="btn btn-success" href="javascript:void(0)" id="createNewProject"> Create New Project2</a>
    </div>
</div>

@include('modals.project2')

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
                    <table class="table table-bordered dt-responsive nowrap data-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>

                            <th width="100px">Logo</th>
                            <th>Mã dự án2</th>
{{--                            <th>Tên Project</th>--}}
{{--                            <th>Tên Template</th>--}}
                            <th>Package</th>
                            <th>Trạng thái Ứng dụng | Policy</th>
                            <th width="10%">Action</th>
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
<script src="plugins/select2/js/select2.min.js"></script>

<script>
    $("#template").select2({});
    $("#ma_da").select2({});
    $("#buildinfo_store_name_x").select2({});
</script>


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
            ajax: {
                url: "{{ route('project2.getIndex') }}",
                type: "post"
            },
            columns: [
                {data: 'logo', name: 'logo'},
                {data: 'ma_da', name: 'ma_da'},
                // {data: 'projectname', name: 'projectname'},
                // {data: 'template', name: 'template'},
                {data: 'package', name: 'package'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createNewProject').click(function () {
            $('#saveBtn').val("create-project");
            $('#project_id').val('');
            $('#projectForm2').trigger("reset");
            $('#modelHeading').html("Thêm mới Project");
            $('#ajaxModel').modal('show');
            $('.modal').on('hidden.bs.modal', function (e) {
                $('body').addClass('modal-open');
            });
        });


        $('#projectForm2').on('submit',function (event){
            event.preventDefault();
            if($('#saveBtn').val() == 'create-project'){
                $.ajax({
                    data: $('#projectForm2').serialize(),
                    url: "{{ route('project2.create') }}",
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
                            $('#projectForm2').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                        }
                    },
                });
            }
            if($('#saveBtn').val() == 'edit-project'){
                $.ajax({
                    data: $('#projectForm2').serialize(),
                    url: "{{ route('project2.update') }}",
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
                            $('#projectForm2').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                        }
                    },
                });
            }
        });
        $('#projectQuickForm').on('submit',function (event){
            event.preventDefault();
            if($('#saveQBtn').val() == 'quick-edit-project'){
                $.ajax({
                    data: $('#projectQuickForm').serialize(),
                    url: "{{ route('project2.updateQuick') }}",
                    type: "post",
                    dataType: 'json',
                    success: function (data) {
                        if(data.errors){
                            for( var count=0 ; count <data.errors.length; count++){
                                $("#projectQuickForm").notify(
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
<script>
    function editProject(id) {
        $.get('{{asset('project2/edit')}}/'+id,function (data) {
            $('#project_id').val(data[0].projectid);
            $('#projectname').val(data[0].projectname);
            $('#template').val(data[0].template);
            $('#template').select2();
            $('#ma_da').val(data[0].ma_da);
            $('#ma_da').select2();
            $('#title_app').val(data[0].title_app);
            $('#buildinfo_vernum').val(data[0].buildinfo_vernum);
            $('#buildinfo_verstr').val(data[0].buildinfo_verstr);
            $('#buildinfo_app_name_x').val(data[0].buildinfo_app_name_x);
            $('#buildinfo_keystore').val(data[0].buildinfo_keystore);
            $('#buildinfo_sdk').val(data[0].buildinfo_sdk);
            $('#buildinfo_link_policy_x').val(data[0].buildinfo_link_policy_x);
            $('#buildinfo_link_youtube_x').val(data[0].buildinfo_link_youtube_x);
            $('#buildinfo_link_fanpage').val(data[0].buildinfo_link_fanpage);
            $('#buildinfo_api_key_x').val(data[0].buildinfo_api_key_x);
            $('#buildinfo_link_website').val(data[0].buildinfo_link_website);


            $('#Chplay_package').val(data[0].Chplay_package);
            $('#Chplay_ads').val(data[0].Chplay_ads);
            $('#Chplay_buildinfo_store_name_x').val(data[0].Chplay_buildinfo_store_name_x);
            $('#Chplay_buildinfo_link_store').val(data[0].Chplay_buildinfo_link_store);
            $('#Chplay_buildinfo_link_app').val(data[0].Chplay_buildinfo_link_app);
            $('#Chplay_buildinfo_email_dev_x').val(data[0].Chplay_buildinfo_email_dev_x);
            $('#Chplay_status').val(data[0].Chplay_status);

            $('#Amazon_package').val(data[0].Amazon_package);
            $('#Amazon_ads').val(data[0].Amazon_ads);
            $('#Amazon_buildinfo_store_name_x').val(data[0].Amazon_buildinfo_store_name_x);
            $('#Amazon_buildinfo_link_store').val(data[0].Amazon_buildinfo_link_store);
            $('#Amazon_buildinfo_link_app').val(data[0].Amazon_buildinfo_link_app);
            $('#Amazon_buildinfo_email_dev_x').val(data[0].Amazon_buildinfo_email_dev_x);
            $('#Amazon_status').val(data[0].Amazon_status);

            $('#Samsung_package').val(data[0].Samsung_package);
            $('#Samsung_ads').val(data[0].Samsung_ads);
            $('#Samsung_buildinfo_store_name_x').val(data[0].Samsung_buildinfo_store_name_x);
            $('#Samsung_buildinfo_link_store').val(data[0].Samsung_buildinfo_link_store);
            $('#Samsung_buildinfo_link_app').val(data[0].Samsung_buildinfo_link_app);
            $('#Samsung_buildinfo_email_dev_x').val(data[0].Samsung_buildinfo_email_dev_x);
            $('#Samsung_status').val(data[0].Samsung_status);

            $('#Xiaomi_package').val(data[0].Xiaomi_package);
            $('#Xiaomi_ads').val(data[0].Xiaomi_ads);
            $('#Xiaomi_buildinfo_store_name_x').val(data[0].Xiaomi_buildinfo_store_name_x);
            $('#Xiaomi_buildinfo_link_store').val(data[0].Xiaomi_buildinfo_link_store);
            $('#Xiaomi_buildinfo_link_app').val(data[0].Xiaomi_buildinfo_link_app);
            $('#Xiaomi_buildinfo_email_dev_x').val(data[0].Xiaomi_buildinfo_email_dev_x);
            $('#Xiaomi_status').val(data[0].Xiaomi_status);

            $('#Oppo_package').val(data[0].Oppo_package);
            $('#Oppo_ads').val(data[0].Oppo_ads);
            $('#Oppo_buildinfo_store_name_x').val(data[0].Oppo_buildinfo_store_name_x);
            $('#Oppo_buildinfo_link_store').val(data[0].Oppo_buildinfo_link_store);
            $('#Oppo_buildinfo_link_app').val(data[0].Oppo_buildinfo_link_app);
            $('#Oppo_buildinfo_email_dev_x').val(data[0].Oppo_buildinfo_email_dev_x);
            $('#Oppo_status').val(data[0].Oppo_status);

            $('#Vivo_package').val(data[0].Vivo_package);
            $('#Vivo_ads').val(data[0].Vivo_ads);
            $('#Vivo_buildinfo_store_name_x').val(data[0].Vivo_buildinfo_store_name_x);
            $('#Vivo_buildinfo_link_store').val(data[0].Vivo_buildinfo_link_store);
            $('#Vivo_buildinfo_link_app').val(data[0].Vivo_buildinfo_link_app);
            $('#Vivo_buildinfo_email_dev_x').val(data[0].Vivo_buildinfo_email_dev_x);
            $('#Vivo_status').val(data[0].Vivo_status);





            $('#modelHeading').html("Edit Project");
            $('#saveBtn').val("edit-project");
            $('#ajaxModel').modal('show');
            $('.modal').on('hidden.bs.modal', function (e) {
                $('body').addClass('modal-open');
            });
        })
    }

    function quickEditProject(id) {
        $.get('{{asset('project2/edit')}}/'+id,function (data) {
            $('#quick_project_id').val(data[0].projectid);
            // $('#quick_projectname').val(data[0].projectname);
            // $('#quick_template').val(data[0].template);
            // $('#quick_ma_da').val(data[0].ma_da);
            // $('#quick_package').val(data[0].package);
            // $('#quick_title_app').val(data[0].title_app);
            // $('#quick_buildinfo_link_policy_x').val(data[0].buildinfo_link_policy_x);
            // $('#quick_buildinfo_link_fanpage').val(data[0].buildinfo_link_fanpage);
            // $('#quick_buildinfo_link_website').val(data[0].buildinfo_link_website);
            // $('#quick_buildinfo_link_store').val(data[0].buildinfo_link_store);
            // $('#quick_buildinfo_app_name_x').val(data[0].buildinfo_app_name_x);
            // $('#quick_buildinfo_store_name_x').val(data[0].buildinfo_store_name_x);

            $('#quick_buildinfo_vernum').val(data[0].buildinfo_vernum);
            $('#quick_buildinfo_verstr').val(data[0].buildinfo_verstr);
            $('#quick_buildinfo_console').val(data[0].buildinfo_console);

            // $('#quick_buildinfo_keystore').val(data[0].buildinfo_keystore);
            // $('#quick_ads_id').val(data[0].ads_id);
            // $('#quick_banner').val(data[0].ads_banner);
            // $('#quick_ads_inter').val(data[0].ads_inter);
            // $('#quick_ads_reward').val(data[0].ads_reward);
            // $('#quick_ads_native').val(data[0].ads_native);
            // $('#quick_ads_open').val(data[0].ads_open);
            // $('#quick_buildinfo_time').val(data[0].buildinfo_time);
            // $('#quick_buildinfo_mess').val(data[0].buildinfo_mess);
            // $('#quick_time_mess').val(data[0].time_mess);
            // $('#quick_buildinfo_email_dev_x').val(data[0].buildinfo_email_dev_x);
            // $('#quick_buildinfo_link_youtube_x').val(data[0].buildinfo_link_youtube_x);
            // $('#quick_buildinfo_api_key_x').val(data[0].buildinfo_api_key_x);
            // $('#quick_status').val(data[0].status);


            $('#modelQuickHeading').html("Quick Edit Project");
            $('#saveQBtn').val("quick-edit-project");
            $('#ajaxQuickModel').modal('show');
        })
    }


    function showPolicy(id) {
        $.get('{{asset('project2/edit')}}/'+id,function (data) {
            if(data[2] == null) { data[2] = '222'}
            if(data[1] == null) { data[1] = ''}
            let policy1 = data[1].policy1.replaceAll("{APP_NAME_X}", data[0].buildinfo_app_name_x).replaceAll("{STORE_NAME_X}", data[2].store_name);
            let policy2 = data[1].policy2.replaceAll("{APP_NAME_X}", data[0].buildinfo_app_name_x).replaceAll("{STORE_NAME_X}", data[2].store_name);
            $('#policy1').val(policy1);
            $('#policy2').val(policy2);
            $('#modelHeadingPolicy').html("Show Policy");
            $('#showPolicy').modal('show');
            $('.modal').on('hidden.bs.modal', function (e) {
                $('body').addClass('modal-open');
            });
        })
    }



</script>


<script>
    $("#AddDaForm").submit(function (e) {
        e.preventDefault();
        let data = new FormData(document.getElementById('AddDaForm'));
        $.ajax({
            url:"{{route('da.create')}}",
            type: "post",
            data:data,
            processData: false,
            contentType: false,
            dataType: 'json',
            beForeSend : () => {

            },
            success:function (data) {
                if(data.errors){
                    for( var count=0 ; count <data.errors.length; count++){
                        $("#AddDaForm").notify(
                            data.errors[count],"error",
                            { position:"right" }
                        );
                    }
                }
                $.notify(data.success, "success");
                $('#AddDaForm').trigger("reset");
                $('#addMaDa').modal('hide');

                if(typeof data.du_an == 'undefined'){
                    data.du_an = {};
                }
                if(typeof rebuildMadaOption == 'function'){
                    rebuildMadaOption(data.du_an)
                }
            }
        });

    });
    $("#AddTempForm").submit(function (e) {
        e.preventDefault();
        let data = new FormData(document.getElementById('AddTempForm'));
        $.ajax({
            url:"{{route('template.create')}}",
            type: "post",
            data:data,
            processData: false,
            contentType: false,
            dataType: 'json',
            beForeSend : () => {

            },
            success:function (data) {
                if(data.errors){
                    for( var count=0 ; count <data.errors.length; count++){
                        $("#AddTempForm").notify(
                            data.errors[count],"error",
                            { position:"right" }
                        );
                    }
                }
                $.notify(data.success, "success");
                $('#AddTempForm').trigger("reset");
                $('#addTemplate').modal('hide');


                if(typeof data.temp == 'undefined'){
                    data.temp = {};
                }
                if(typeof rebuildTemplateOption == 'function'){
                    rebuildTemplateOption(data.temp)
                }
            }
        });

    });
    $("#addStore").submit(function (e) {
        alert(1);
        e.preventDefault();
        let data = new FormData(document.getElementById('AddDaForm'));
        $.ajax({
            url:"{{route('da.create')}}",
            type: "post",
            data:data,
            processData: false,
            contentType: false,
            dataType: 'json',
            beForeSend : () => {

            },
            success:function (data) {
                if(data.errors){
                    for( var count=0 ; count <data.errors.length; count++){
                        $("#AddDaForm").notify(
                            data.errors[count],"error",
                            { position:"right" }
                        );
                    }
                }
                $.notify(data.success, "success");
                $('#AddDaForm').trigger("reset");
                $('#addMaDa').modal('hide');

                if(typeof data.du_an == 'undefined'){
                    data.du_an = {};
                }
                if(typeof rebuildMadaOption == 'function'){
                    rebuildMadaOption(data.du_an)
                }
            }
        });

    });
</script>
<script>
    function rebuildMadaOption(du_an){
        var elementSelect = $("#ma_da");

        if(elementSelect.length <= 0){
            return false;
        }
        elementSelect.empty();

        for(var da of du_an){
            elementSelect.append(
                $("<option></option>", {
                    value : da.id
                }).text(da.ma_da)
            );
        }
    }
    function rebuildTemplateOption(template){
        var elementSelect = $("#template");
        if(elementSelect.length <= 0){
            return false;
        }
        elementSelect.empty();

        for(var temp of template){
            elementSelect.append(
                $("<option></option>", {
                    value : temp.id
                }).text(temp.template)
            );
        }
    }
</script>


@endsection

