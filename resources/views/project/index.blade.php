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
    <h4 class="page-title">Quản lý Project</h4>
</div>
<div class="col-sm-6">
    <div class="col-sm-6 float-right">
        <div >
            <a class="btn btn-success" href="javascript:void(0)" id="createNewProject"> Create New Project</a>
        </div>
    </div>
    <div class="col-sm-6 float-right">
        <div class="float-right">
            <a class="btn btn-warning" href="javascript:void(0)" id="checkData">Check data</a>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="showMess" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeadingPolicy"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="message-full"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@include('modals.project')

@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered dt-responsive nowrap data-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th >ID</th>
                            <th>Logo</th>
                            <th >Mã Project</th>
                            <th>Package</th>
                            <th>Trạng thái Ứng dụng | Policy</th>
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
            displayLength: 50,
            lengthMenu: [5, 10, 25, 50, 75, 100],
            // processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('project.getIndex') }}",
                type: "post"
            },
            columns: [
                {data: 'created_at', name: 'created_at',},
                {data: 'logo', name: 'logo',orderable: false},
                {data: 'projectname', name: 'projectname'},
                {data: 'package', name: 'package',orderable: false},
                {data: 'status', name: 'status',orderable: false},
                {data: 'action', name: 'action',className: "text-center", orderable: false, searchable: false},
            ],
            columnDefs: [
                {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                }
            ],
            order: [[ 0, 'desc' ]]
        });


        $('#createNewProject').click(function () {
            $('#saveBtn').val("create-project");
            $('#project_id').val('');
            $("#avatar").attr("src","img/logo.png");
            $('#projectForm2').trigger("reset");
            $('#template').select2();
            $('#ma_da').select2();
            $('#modelHeading').html("Thêm mới Project");
            $('#ajaxModel').modal('show');
            $('.modal').on('hidden.bs.modal', function (e) {
                $('body').addClass('modal-open');
            });
            $('.market_chplay').hide()
            $('.market_amazon').hide()
            $('.market_samsung').hide()
            $('.market_xiaomi').hide()
            $('.market_oppo').hide()
            $('.market_vivo').hide()
            $('#Chplay_ads_id').hide();
            $('#Chplay_ads_banner').hide();
            $('#Chplay_ads_inter').hide();
            $('#Chplay_ads_reward').hide();
            $('#Chplay_ads_native').hide();
            $('#Chplay_ads_open').hide();

            $('#Amazon_ads_id').hide();
            $('#Amazon_ads_banner').hide();
            $('#Amazon_ads_inter').hide();
            $('#Amazon_ads_reward').hide();
            $('#Amazon_ads_native').hide();
            $('#Amazon_ads_open').hide();

            $('#Xiaomi_ads_id').hide();
            $('#Xiaomi_ads_banner').hide();
            $('#Xiaomi_ads_inter').hide();
            $('#Xiaomi_ads_reward').hide();
            $('#Xiaomi_ads_native').hide();
            $('#Xiaomi_ads_open').hide();

            $('#Samsung_ads_id').hide();
            $('#Samsung_ads_banner').hide();
            $('#Samsung_ads_inter').hide();
            $('#Samsung_ads_reward').hide();
            $('#Samsung_ads_native').hide();
            $('#Samsung_ads_open').hide();

            $('#Oppo_ads_id').hide();
            $('#Oppo_ads_banner').hide();
            $('#Oppo_ads_inter').hide();
            $('#Oppo_ads_reward').hide();
            $('#Oppo_ads_native').hide();
            $('#Oppo_ads_open').hide();

            $('#Vivo_ads_id').hide();
            $('#Vivo_ads_banner').hide();
            $('#Vivo_ads_inter').hide();
            $('#Vivo_ads_reward').hide();
            $('#Vivo_ads_native').hide();
            $('#Vivo_ads_open').hide();

            $('.a_chplay').hide();
            $('.a_amazon').hide();
            $('.a_samsung').hide();
            $('.a_xiaomi').hide();
            $('.a_oppo').hide();
            $('.a_vivo').hide();
        });
        $('#projectForm2').on('submit',function (event){
            event.preventDefault();
            var formData = new FormData($("#projectForm2")[0]);
            if($('#saveBtn').val() == 'create-project'){
                $.ajax({
                    // data: $('#projectForm2').serialize(),
                    data: formData,
                    url: "{{ route('project.create') }}",
                    type: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if(data.errors){
                            for( var count=0 ; count <data.errors.length; count++){
                                $("#projectForm2").notify(
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
                    // data: $('#projectForm2').serialize(),
                    data: formData,
                    url: "{{ route('project.update') }}",
                    type: "post",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if(data.errors){
                            for( var count=0 ; count <data.errors.length; count++){
                                $("#projectForm2").notify(
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
                    url: "{{ route('project.updateQuick') }}",
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
        $(document).on('click','.showLog_Project', e=>{
            const row = table.row(e.target.closest('tr'));
            const rowData = row.data();
            $('#modelHeadingPolicy').html(rowData.name_projectname);
            $('#showMess').modal('show');
            $('.message-full').html(rowData.log);

        });
        $(document).on('click','#checkData', function (data){
            swal({
                    title: "Bạn có chắc muốn check Data?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Xác nhận!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type: "get",
                        url: "{{ asset("project/checkData") }}/",
                        success: function (data) {
                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                    swal("OK!", '', "success");
                });
        });
    });
</script>
<script>
    function editProject(id) {
        $.get('{{asset('project/edit')}}/'+id,function (data) {
            var ads = JSON.parse(data[4].ads);
            var Chplay_ads = '';
            var Amazon_ads = '';
            var Samsung_ads = '';
            var Xiaomi_ads = '';
            var Oppo_ads = '';
            var Vivo_ads = '';
            if(data[0].Chplay_ads) {
                Chplay_ads = data[0].Chplay_ads;
                Chplay_ads = JSON.parse(Chplay_ads);
            }
            if(data[0].Amazon_ads){
                Amazon_ads = data[0].Amazon_ads;
                Amazon_ads = JSON.parse(Amazon_ads);
            }
            if(data[0].Samsung_ads) {
                Samsung_ads = data[0].Samsung_ads;
                Samsung_ads = JSON.parse(Samsung_ads);
            }
            if(data[0].Xiaomi_ads) {
                Xiaomi_ads = data[0].Xiaomi_ads;
                Xiaomi_ads = JSON.parse(Xiaomi_ads);
            }
            if(data[0].Oppo_ads) {
                Oppo_ads = data[0].Oppo_ads;
                Oppo_ads = JSON.parse(Oppo_ads);
            }
            if(data[0].Vivo_ads) {
                Vivo_ads = data[0].Vivo_ads;
                Vivo_ads = JSON.parse(Vivo_ads);
            }
            if(data[0].logo) {
                $("#avatar").attr("src","../uploads/project/"+data[0].projectname+"/thumbnail/"+data[0].logo);
            }else {
                $("#avatar").attr("src","img/logo.png");
            }

            if(data[4].Chplay_category !=null){
                $('.market_chplay').show()
                $('.a_chplay').show()
                $('#Chplay_package').val(data[0].Chplay_package);
                if(data[0].Chplay_package == null){
                    $('#Chplay_package').attr("placeholder", data[4].package);
                }
                $('#Chplay_ads_id').val(Chplay_ads.ads_id);
                $('#Chplay_ads_banner').val(Chplay_ads.ads_banner);
                $('#Chplay_ads_inter').val(Chplay_ads.ads_inter);
                $('#Chplay_ads_reward').val(Chplay_ads.ads_reward);
                $('#Chplay_ads_native').val(Chplay_ads.ads_native);
                $('#Chplay_ads_open').val(Chplay_ads.ads_open);
            }else{
                $('.market_chplay').hide()
                $('.a_chplay').hide()
                $('#Chplay_package').val('');
                $('#Chplay_ads_id').val('');
                $('#Chplay_ads_banner').val('');
                $('#Chplay_ads_inter').val('');
                $('#Chplay_ads_reward').val('');
                $('#Chplay_ads_native').val('');
                $('#Chplay_ads_open').val('');
            }

            if(data[4].Amazon_category !=null){
                $('.market_amazon').show()
                $('.a_amazon').show()
                $('#Amazon_package').val(data[0].Amazon_package);
                if(data[0].Amazon_package == null){
                    $('#Amazon_package').attr("placeholder", data[4].package);
                }
                $('#Amazon_ads_id').val(Amazon_ads.ads_id);
                $('#Amazon_ads_banner').val(Amazon_ads.ads_banner);
                $('#Amazon_ads_inter').val(Amazon_ads.ads_inter);
                $('#Amazon_ads_reward').val(Amazon_ads.ads_reward);
                $('#Amazon_ads_native').val(Amazon_ads.ads_native);
                $('#Amazon_ads_open').val(Amazon_ads.ads_open);

            }else{
                $('.market_amazon').hide()
                $('.a_amazon').hide()
                $('#Amazon_ads_id').val('');
                $('#Amazon_ads_banner').val('');
                $('#Amazon_ads_inter').val('');
                $('#Amazon_ads_reward').val('');
                $('#Amazon_ads_native').val('');
                $('#Amazon_ads_open').val('');

            }
            if(data[4].Samsung_category !=null){
                $('.market_samsung').show()
                $('.a_samsung').show()
                $('#Samsung_package').val(data[0].Samsung_package);
                if(data[0].Samsung_package == null){
                    $('#Samsung_package').attr("placeholder", data[4].package);
                }
                $('#Samsung_ads_id').val(Samsung_ads.ads_id);
                $('#Samsung_ads_banner').val(Samsung_ads.ads_banner);
                $('#Samsung_ads_inter').val(Samsung_ads.ads_inter);
                $('#Samsung_ads_native').val(Samsung_ads.ads_native);
                $('#Samsung_ads').val(Samsung_ads.ads_reward);
                $('#Samsung_ads_open').val(Samsung_ads.ads_open);
            }else{
                $('.market_samsung').hide()
                $('.a_samsung').hide()
                $('#Samsung_ads_id').val('');
                $('#Samsung_ads_banner').val('');
                $('#Samsung_ads_inter').val('');
                $('#Samsung_ads_native').val('');
                $('#Samsung_ads').val('');
                $('#Samsung_ads_open').val('');
            }
            if(data[4].Xiaomi_category !=null){
                $('.market_xiaomi').show()
                $('.a_xiaomi').show()
                $('#Xiaomi_package').val(data[0].Xiaomi_package);
                $('#Xiaomi_package').val(data[0].Xiaomi_package);
                if(data[0].Xiaomi_package == null){
                    $('#Xiaomi_package').attr("placeholder", data[4].package);
                }
                $('#Xiaomi_ads_id').val(Xiaomi_ads.ads_id);
                $('#Xiaomi_ads_banner').val(Xiaomi_ads.ads_banner);
                $('#Xiaomi_ads_inter').val(Xiaomi_ads.ads_inter);
                $('#Xiaomi_ads_reward').val(Xiaomi_ads.ads_reward);
                $('#Xiaomi_ads_native').val(Xiaomi_ads.ads_native);
                $('#Xiaomi_ads_open').val(Xiaomi_ads.ads_open);
            }else{
                $('.market_xiaomi').hide()
                $('.a_xiaomi').hide()
                $('#Xiaomi_ads_id').val('');
                $('#Xiaomi_ads_banner').val('');
                $('#Xiaomi_ads_inter').val('');
                $('#Xiaomi_ads_reward').val('');
                $('#Xiaomi_ads_native').val('');
                $('#Xiaomi_ads_open').val('');
            }
            if(data[4].Oppo_category !=null){
                $('.market_oppo').show()
                $('.ma_oppo').show()
                $('#Oppo_package').val(data[0].Oppo_package);
                if(data[0].Oppo_package == null){
                    $('#Oppo_package').attr("placeholder", data[4].package);
                }
                $('#Oppo_ads_id').val(Oppo_ads.ads_id);
                $('#Oppo_ads_banner').val(Oppo_ads.ads_banner);
                $('#Oppo_ads_inter').val(Oppo_ads.ads_inter);
                $('#Oppo_ads_reward').val(Oppo_ads.ads_reward);
                $('#Oppo_ads_native').val(Oppo_ads.ads_native);
                $('#Oppo_ads_open').val(Oppo_ads.ads_open);
            }else{
                $('.market_oppo').hide()
                $('.a_oppo').hide()
                $('#Oppo_ads_id').val('');
                $('#Oppo_ads_banner').val('');
                $('#Oppo_ads_inter').val('');
                $('#Oppo_ads_reward').val('');
                $('#Oppo_ads_native').val('');
                $('#Oppo_ads_open').val('');
            }
            if(data[4].Vivo_category !=null){
                $('.market_vivo').show()
                $('.a_vivo').show()
                $('#Vivo_package').val(data[0].Vivo_package);
                if(data[0].Vivo_package == null){
                    $('#Vivo_package').attr("placeholder", data[4].package);
                }
                $('#Vivo_ads_id').val(Vivo_ads.ads_id);
                $('#Vivo_ads_banner').val(Vivo_ads.ads_banner);
                $('#Vivo_ads_inter').val(Vivo_ads.ads_inter);
                $('#Vivo_ads_reward').val(Vivo_ads.ads_reward);
                $('#Vivo_ads_native').val(Vivo_ads.ads_native);
                $('#Vivo_ads_open').val(Vivo_ads.ads_open);

            }else{
                $('.market_vivo').hide()
                $('.a_vivo').hide()
                $('#Vivo_ads_id').val('');
                $('#Vivo_ads_banner').val('');
                $('#Vivo_ads_inter').val('');
                $('#Vivo_ads_reward').val('');
                $('#Vivo_ads_native').val('');
                $('#Vivo_ads_open').val('');
            }
            if(ads !=null){
                if(ads.ads_id !=null){
                    $('#Chplay_ads_id').show();
                    $('#Amazon_ads_id').show();
                    $('#Samsung_ads_id').show();
                    $('#Xiaomi_ads_id').show();
                    $('#Oppo_ads_id').show();
                    $('#Vivo_ads_id').show();
                }else {
                    $('#Chplay_ads_id').hide();
                    $('#Amazon_ads_id').hide();
                    $('#Samsung_ads_id').hide();
                    $('#Xiaomi_ads_id').hide();
                    $('#Oppo_ads_id').hide();
                    $('#Vivo_ads_id').hide();
                }
                if(ads.ads_banner!=null){
                    $('#Chplay_ads_banner').show();
                    $('#Amazon_ads_banner').show();
                    $('#Samsung_ads_banner').show();
                    $('#Xiaomi_ads_banner').show();
                    $('#Oppo_ads_banner').show();
                    $('#Vivo_ads_banner').show();
                }else {
                    $('#Chplay_ads_banner').hide();
                    $('#Amazon_ads_banner').hide();
                    $('#Samsung_ads_banner').hide();
                    $('#Xiaomi_ads_banner').hide();
                    $('#Oppo_ads_banner').hide();
                    $('#Vivo_ads_banner').hide();
                }
                if(ads.ads_inter !=null){
                    $('#Chplay_ads_inter').show();
                    $('#Amazon_ads_inter').show();
                    $('#Samsung_ads_inter').show();
                    $('#Xiaomi_ads_inter').show();
                    $('#Oppo_ads_inter').show();
                    $('#Vivo_ads_inter').show();
                }else {
                    $('#Chplay_ads_inter').hide();
                    $('#Amazon_ads_inter').hide();
                    $('#Samsung_ads_inter').hide();
                    $('#Xiaomi_ads_inter').hide();
                    $('#Oppo_ads_inter').hide();
                    $('#Vivo_ads_inter').hide();
                }
                if(ads.ads_reward !=null){
                    $('#Chplay_ads_reward').show();
                    $('#Amazon_ads_reward').show();
                    $('#Samsung_ads_reward').show();
                    $('#Xiaomi_ads_reward').show();
                    $('#Oppo_ads_reward').show();
                    $('#Vivo_ads_reward').show();
                }else {
                    $('#Chplay_ads_reward').hide();
                    $('#Amazon_ads_reward').hide();
                    $('#Samsung_ads_reward').hide();
                    $('#Xiaomi_ads_reward').hide();
                    $('#Oppo_ads_reward').hide();
                    $('#Vivo_ads_reward').hide();
                }
                if(ads.ads_native !=null){
                    $('#Chplay_ads_native').show();
                    $('#Amazon_ads_native').show();
                    $('#Samsung_ads_native').show();
                    $('#Xiaomi_ads_native').show();
                    $('#Oppo_ads_native').show();
                    $('#Vivo_ads_native').show();
                }else {
                    $('#Chplay_ads_native').hide();
                    $('#Amazon_ads_native').hide();
                    $('#Samsung_ads_native').hide();
                    $('#Xiaomi_ads_native').hide();
                    $('#Oppo_ads_native').hide();
                    $('#Vivo_ads_native').hide();
                }
                if(ads.ads_open !=null){
                    $('#Chplay_ads_open').show();
                    $('#Amazon_ads_open').show();
                    $('#Samsung_ads_open').show();
                    $('#Xiaomi_ads_open').show();
                    $('#Oppo_ads_open').show();
                    $('#Vivo_ads_open').show();
                }else {
                    $('#Chplay_ads_open').hide();
                    $('#Amazon_ads_open').hide();
                    $('#Samsung_ads_open').hide();
                    $('#Xiaomi_ads_open').hide();
                    $('#Oppo_ads_open').hide();
                    $('#Vivo_ads_open').hide();
                }
            }else {
                $('#Chplay_ads_id').hide();
                $('#Amazon_ads_id').hide();
                $('#Samsung_ads_id').hide();
                $('#Xiaomi_ads_id').hide();
                $('#Oppo_ads_id').hide();
                $('#Vivo_ads_id').hide();

                $('#Chplay_ads_banner').hide();
                $('#Amazon_ads_banner').hide();
                $('#Samsung_ads_banner').hide();
                $('#Xiaomi_ads_banner').hide();
                $('#Oppo_ads_banner').hide();
                $('#Vivo_ads_banner').hide();

                $('#Chplay_ads_inter').hide();
                $('#Amazon_ads_inter').hide();
                $('#Samsung_ads_inter').hide();
                $('#Xiaomi_ads_inter').hide();
                $('#Oppo_ads_inter').hide();
                $('#Vivo_ads_inter').hide();

                $('#Chplay_ads_reward').hide();
                $('#Amazon_ads_reward').hide();
                $('#Samsung_ads_reward').hide();
                $('#Xiaomi_ads_reward').hide();
                $('#Oppo_ads_reward').hide();
                $('#Vivo_ads_reward').hide();

                $('#Chplay_ads_native').hide();
                $('#Amazon_ads_native').hide();
                $('#Samsung_ads_native').hide();
                $('#Xiaomi_ads_native').hide();
                $('#Oppo_ads_native').hide();
                $('#Vivo_ads_native').hide();

                $('#Chplay_ads_open').hide();
                $('#Amazon_ads_open').hide();
                $('#Samsung_ads_open').hide();
                $('#Xiaomi_ads_open').hide();
                $('#Oppo_ads_open').hide();
                $('#Vivo_ads_open').hide();
            }

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
            $('#link_store_vietmmo').val(data[0].link_store_vietmmo);

            $('#Chplay_buildinfo_store_name_x').val(data[0].Chplay_buildinfo_store_name_x);
            $('#Chplay_buildinfo_link_store').val(data[0].Chplay_buildinfo_link_store);
            $('#Chplay_buildinfo_link_app').val(data[0].Chplay_buildinfo_link_app);
            $('#Chplay_buildinfo_email_dev_x').val(data[0].Chplay_buildinfo_email_dev_x);
            $('#Chplay_status').val(data[0].Chplay_status);
            $('#Chplay_policy').val(data[0].Chplay_policy);

            $('#Amazon_buildinfo_store_name_x').val(data[0].Amazon_buildinfo_store_name_x);
            $('#Amazon_buildinfo_link_store').val(data[0].Amazon_buildinfo_link_store);
            $('#Amazon_buildinfo_link_app').val(data[0].Amazon_buildinfo_link_app);
            $('#Amazon_buildinfo_email_dev_x').val(data[0].Amazon_buildinfo_email_dev_x);
            $('#Amazon_status').val(data[0].Amazon_status);
            $('#Amazon_policy').val(data[0].Amazon_policy);



            $('#Samsung_buildinfo_store_name_x').val(data[0].Samsung_buildinfo_store_name_x);
            $('#Samsung_buildinfo_link_store').val(data[0].Samsung_buildinfo_link_store);
            $('#Samsung_buildinfo_link_app').val(data[0].Samsung_buildinfo_link_app);
            $('#Samsung_buildinfo_email_dev_x').val(data[0].Samsung_buildinfo_email_dev_x);
            $('#Samsung_status').val(data[0].Samsung_status);
            $('#Samsung_policy').val(data[0].Samsung_policy);

            $('#Xiaomi_buildinfo_store_name_x').val(data[0].Xiaomi_buildinfo_store_name_x);
            $('#Xiaomi_buildinfo_link_store').val(data[0].Xiaomi_buildinfo_link_store);
            $('#Xiaomi_buildinfo_link_app').val(data[0].Xiaomi_buildinfo_link_app);
            $('#Xiaomi_buildinfo_email_dev_x').val(data[0].Xiaomi_buildinfo_email_dev_x);
            $('#Xiaomi_status').val(data[0].Xiaomi_status);
            $('#Xiaomi_policy').val(data[0].Xiaomi_policy);

            $('#Oppo_buildinfo_store_name_x').val(data[0].Oppo_buildinfo_store_name_x);
            $('#Oppo_buildinfo_link_store').val(data[0].Oppo_buildinfo_link_store);
            $('#Oppo_buildinfo_link_app').val(data[0].Oppo_buildinfo_link_app);
            $('#Oppo_buildinfo_email_dev_x').val(data[0].Oppo_buildinfo_email_dev_x);
            $('#Oppo_status').val(data[0].Oppo_status);
            $('#Oppo_policy').val(data[0].Oppo_policy);


            $('#Vivo_buildinfo_store_name_x').val(data[0].Vivo_buildinfo_store_name_x);
            $('#Vivo_buildinfo_link_store').val(data[0].Vivo_buildinfo_link_store);
            $('#Vivo_buildinfo_link_app').val(data[0].Vivo_buildinfo_link_app);
            $('#Vivo_buildinfo_email_dev_x').val(data[0].Vivo_buildinfo_email_dev_x);
            $('#Vivo_status').val(data[0].Vivo_status);
            $('#Vivo_policy').val(data[0].Vivo_policy);

            $('#modelHeading').html("Edit Project");
            $('#saveBtn').val("edit-project");
            $('#ajaxModel').modal('show');
            $('.modal').on('hidden.bs.modal', function (e) {
                $('body').addClass('modal-open');
            });
        })
    }


    function quickEditProject(id) {
        $.get('{{asset('project/edit')}}/'+id,function (data) {
            $('#quick_project_id').val(data[0].projectid);
            $('#quick_buildinfo_vernum').val(data[0].buildinfo_vernum);
            $('#quick_buildinfo_verstr').val(data[0].buildinfo_verstr);
            $('#quick_buildinfo_console').val(data[0].buildinfo_console);
            $('#modelQuickHeading').html("Quick Edit Project");
            $('#saveQBtn').val("quick-edit-project");
            $('#ajaxQuickModel').modal('show');
        })
    }
    function showPolicy(id) {
        $.get('{{asset('project/edit')}}/'+id,function (data) {
            if(data[2] == null) { data[2] = {store_name: "(NO STORE NAME)"}}
            if(data[1].policy1){
                $('.policy-1').show();
                if(data[0].buildinfo_app_name_x == null){
                    var app_name_x = '(NO APP NAME)'
                }else{
                    var app_name_x = data[0].buildinfo_app_name_x;
                }
                let policy1 = data[1].policy1
                    .replaceAll("{APP_NAME_X}", app_name_x)
                    .replaceAll("APP_NAME_X", app_name_x)
                    .replaceAll("{STORE_NAME_X}", data[2].store_name)
                    .replaceAll("STORE_NAME_X", data[2].store_name);
                $('#policy1').val(policy1);
            }else {
                $('.policy-1').hide();
            }
            if(data[1].policy2) {
                $('.policy-2').show();
                if(data[0].buildinfo_app_name_x == null){
                    var app_name_x = '(NO APP NAME)'
                }else{
                    var app_name_x = data[0].buildinfo_app_name_x;
                }
                let policy2 = data[1].policy2
                    .replaceAll("{APP_NAME_X}", app_name_x)
                    .replaceAll("APP_NAME_X", app_name_x)
                    .replaceAll("{STORE_NAME_X}", data[2].store_name)
                    .replaceAll("STORE_NAME_X", data[2].store_name);
                $('#policy2').val(policy2);
            }else {
                $('.policy-2').hide();
            }
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
                var ads = jQuery.parseJSON(data.temp[0].ads);

                if(ads.ads_id != null){
                    $('#Chplay_ads_id').show();
                    $('#Amazon_ads_id').show();
                    $('#Samsung_ads_id').show();
                    $('#Xiaomi_ads_id').show();
                    $('#Oppo_ads_id').show();
                    $('#Vivo_ads_id').show();
                }else {
                    $('#Chplay_ads_id').hide();
                    $('#Amazon_ads_id').hide();
                    $('#Samsung_ads_id').hide();
                    $('#Xiaomi_ads_id').hide();
                    $('#Oppo_ads_id').hide();
                    $('#Vivo_ads_id').hide();
                }
                if(ads.ads_banner != null){
                    $('#Chplay_ads_banner').show();
                    $('#Amazon_ads_banner').show();
                    $('#Xiaomi_ads_banner').show();
                    $('#Samsung_ads_banner').show();
                    $('#Oppo_ads_banner').show();
                    $('#Vivo_ads_banner').show();
                }else {
                    $('#Chplay_ads_banner').hide();
                    $('#Amazon_ads_banner').hide();
                    $('#Xiaomi_ads_banner').hide();
                    $('#Samsung_ads_banner').hide();
                    $('#Oppo_ads_banner').hide();
                    $('#Vivo_ads_banner').hide();
                }
                if(ads.ads_inter != null){
                    $('#Chplay_ads_inter').show();
                    $('#Amazon_ads_inter').show();
                    $('#Xiaomi_ads_inter').show();
                    $('#Samsung_ads_inter').show();
                    $('#Oppo_ads_inter').show();
                    $('#Vivo_ads_inter').show();
                }else {
                    $('#Chplay_ads_inter').hide();
                    $('#Amazon_ads_inter').hide();
                    $('#Xiaomi_ads_inter').hide();
                    $('#Samsung_ads_inter').hide();
                    $('#Oppo_ads_inter').hide();
                    $('#Vivo_ads_inter').hide();
                }
                if(ads.ads_reward != null){
                    $('#Chplay_ads_reward').show();
                    $('#Amazon_ads_reward').show();
                    $('#Samsung_ads_reward').show();
                    $('#Xiaomi_ads_reward').show();
                    $('#Oppo_ads_reward').show();
                    $('#Vivo_ads_reward').show();
                }else {
                    $('#Chplay_ads_reward').hide();
                    $('#Amazon_ads_reward').hide();
                    $('#Samsung_ads_reward').hide();
                    $('#Xiaomi_ads_reward').hide();
                    $('#Oppo_ads_reward').hide();
                    $('#Vivo_ads_reward').hide();
                }
                if(ads.ads_native != null){
                    $('#Chplay_ads_native').show();
                    $('#Amazon_ads_native').show();
                    $('#Samsung_ads_native').show();
                    $('#Xiaomi_ads_native').show();
                    $('#Oppo_ads_native').show();
                    $('#Vivo_ads_native').show();
                }else {
                    $('#Chplay_ads_native').hide();
                    $('#Amazon_ads_native').hide();
                    $('#Samsung_ads_native').hide();
                    $('#Xiaomi_ads_native').hide();
                    $('#Oppo_ads_native').hide();
                    $('#Vivo_ads_native').hide();
                }
                if(ads.ads_open != null){
                    $('#Chplay_ads_open').show();
                    $('#Amazon_ads_open').show();
                    $('#Samsung_ads_open').show();
                    $('#Xiaomi_ads_open').show();
                    $('#Oppo_ads_open').show();
                    $('#Vivo_ads_open').show();
                }else {
                    $('#Chplay_ads_open').hide();
                    $('#Amazon_ads_open').hide();
                    $('#Samsung_ads_open').hide();
                    $('#Xiaomi_ads_open').hide();
                    $('#Oppo_ads_open').hide();
                    $('#Vivo_ads_open').hide();
                }

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
    $('.choose_template').change(function (){
        var template = $(this).val();
        var _token = $('input[name=_token]').val();
        $.ajax({
            url: '{{asset('project/select-template')}}',
            type: "post",
            data: {
                template:template,
                _token:_token
            },
            success:function (data){

                var ads = jQuery.parseJSON(data.ads);
                $('#Chplay_package').attr("placeholder",data.package);
                $('#Amazon_package').attr("placeholder",data.package);
                $('#Samsung_package').attr("placeholder",data.package);
                $('#Xiaomi_package').attr("placeholder",data.package);
                $('#Oppo_package').attr("placeholder",data.package);
                $('#Vivo_package').attr("placeholder",data.package);
                if(data.Chplay_category != null){
                    $('.market_chplay').show();
                    $('.a_chplay').show();
                }else {
                    $('.market_chplay').hide();
                    $('.a_chplay').hide();
                }

                if(data.Amazon_category != null){
                    $('.market_amazon').show();
                    $('.a_amazon').show();
                }else {
                    $('.market_amazon').hide();
                    $('.a_amazon').hide();
                }

                if(data.Samsung_category != null){
                    $('.market_samsung').show();
                    $('.a_samsung').show();
                }else {
                    $('.market_samsung').hide();
                    $('.a_samsung').hide();
                }

                if(data.Xiaomi_category != null){
                    $('.market_xiaomi').show();
                    $('.a_xiaomi').show();
                }else {
                    $('.market_xiaomi').hide();
                    $('.a_xiaomi').hide();
                }

                if(data.Oppo_category != null){
                    $('.market_oppo').show();
                    $('.a_oppo').show();
                }else {
                    $('.market_oppo').hide();
                    $('.a_oppo').hide();
                }

                if(data.Chplay_category != null){
                    $('.market_chplay').show();
                    $('.a_chplay').show();
                }else {
                    $('.a_chplay').hide();
                }
                if(ads != null){
                    if(ads.ads_id != null){
                        $('#Chplay_ads_id').show();
                        $('#Amazon_ads_id').show();
                        $('#Samsung_ads_id').show();
                        $('#Xiaomi_ads_id').show();
                        $('#Oppo_ads_id').show();
                        $('#Vivo_ads_id').show();
                    }else {
                        $('#Chplay_ads_id').hide();
                        $('#Amazon_ads_id').hide();
                        $('#Samsung_ads_id').hide();
                        $('#Xiaomi_ads_id').hide();
                        $('#Oppo_ads_id').hide();
                        $('#Vivo_ads_id').hide();
                    }
                    if(ads.ads_banner != null){
                        $('#Chplay_ads_banner').show();
                        $('#Amazon_ads_banner').show();
                        $('#Xiaomi_ads_banner').show();
                        $('#Samsung_ads_banner').show();
                        $('#Oppo_ads_banner').show();
                        $('#Vivo_ads_banner').show();
                    }else {
                        $('#Chplay_ads_banner').hide();
                        $('#Amazon_ads_banner').hide();
                        $('#Xiaomi_ads_banner').hide();
                        $('#Samsung_ads_banner').hide();
                        $('#Oppo_ads_banner').hide();
                        $('#Vivo_ads_banner').hide();
                    }
                    if(ads.ads_inter != null){
                        $('#Chplay_ads_inter').show();
                        $('#Amazon_ads_inter').show();
                        $('#Xiaomi_ads_inter').show();
                        $('#Samsung_ads_inter').show();
                        $('#Oppo_ads_inter').show();
                        $('#Vivo_ads_inter').show();
                    }else {
                        $('#Chplay_ads_inter').hide();
                        $('#Amazon_ads_inter').hide();
                        $('#Xiaomi_ads_inter').hide();
                        $('#Samsung_ads_inter').hide();
                        $('#Oppo_ads_inter').hide();
                        $('#Vivo_ads_inter').hide();
                    }
                    if(ads.ads_reward != null){
                        $('#Chplay_ads_reward').show();
                        $('#Amazon_ads_reward').show();
                        $('#Samsung_ads_reward').show();
                        $('#Xiaomi_ads_reward').show();
                        $('#Oppo_ads_reward').show();
                        $('#Vivo_ads_reward').show();
                    }else {
                        $('#Chplay_ads_reward').hide();
                        $('#Amazon_ads_reward').hide();
                        $('#Samsung_ads_reward').hide();
                        $('#Xiaomi_ads_reward').hide();
                        $('#Oppo_ads_reward').hide();
                        $('#Vivo_ads_reward').hide();
                    }
                    if(ads.ads_native != null){
                        $('#Chplay_ads_native').show();
                        $('#Amazon_ads_native').show();
                        $('#Samsung_ads_native').show();
                        $('#Xiaomi_ads_native').show();
                        $('#Oppo_ads_native').show();
                        $('#Vivo_ads_native').show();
                    }else {
                        $('#Chplay_ads_native').hide();
                        $('#Amazon_ads_native').hide();
                        $('#Samsung_ads_native').hide();
                        $('#Xiaomi_ads_native').hide();
                        $('#Oppo_ads_native').hide();
                        $('#Vivo_ads_native').hide();
                    }
                    if(ads.ads_open != null){
                        $('#Chplay_ads_open').show();
                        $('#Amazon_ads_open').show();
                        $('#Samsung_ads_open').show();
                        $('#Xiaomi_ads_open').show();
                        $('#Oppo_ads_open').show();
                        $('#Vivo_ads_open').show();
                    }else {
                        $('#Chplay_ads_open').hide();
                        $('#Amazon_ads_open').hide();
                        $('#Samsung_ads_open').hide();
                        $('#Xiaomi_ads_open').hide();
                        $('#Oppo_ads_open').hide();
                        $('#Vivo_ads_open').hide();
                    }
                }else {
                    $('#Chplay_ads_id').hide();
                    $('#Chplay_ads_banner').hide();
                    $('#Chplay_ads_inter').hide();
                    $('#Chplay_ads_reward').hide();
                    $('#Chplay_ads_native').hide();
                    $('#Chplay_ads_open').hide();

                    $('#Amazon_ads_id').hide();
                    $('#Amazon_ads_banner').hide();
                    $('#Amazon_ads_inter').hide();
                    $('#Amazon_ads_reward').hide();
                    $('#Amazon_ads_native').hide();
                    $('#Amazon_ads_open').hide();

                    $('#Xiaomi_ads_id').hide();
                    $('#Xiaomi_ads_banner').hide();
                    $('#Xiaomi_ads_inter').hide();
                    $('#Xiaomi_ads_reward').hide();
                    $('#Xiaomi_ads_native').hide();
                    $('#Xiaomi_ads_open').hide();

                    $('#Samsung_ads_id').hide();
                    $('#Samsung_ads_banner').hide();
                    $('#Samsung_ads_inter').hide();
                    $('#Samsung_ads_reward').hide();
                    $('#Samsung_ads_native').hide();
                    $('#Samsung_ads_open').hide();

                    $('#Oppo_ads_id').hide();
                    $('#Oppo_ads_banner').hide();
                    $('#Oppo_ads_inter').hide();
                    $('#Oppo_ads_reward').hide();
                    $('#Oppo_ads_native').hide();
                    $('#Oppo_ads_open').hide();

                    $('#Vivo_ads_id').hide();
                    $('#Vivo_ads_banner').hide();
                    $('#Vivo_ads_inter').hide();
                    $('#Vivo_ads_reward').hide();
                    $('#Vivo_ads_native').hide();
                    $('#Vivo_ads_open').hide();
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


