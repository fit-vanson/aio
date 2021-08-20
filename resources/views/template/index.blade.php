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
                            <th>Phân loại</th>
                            <th>Link CHPlay</th>
                            <th>script_copy | IMG | svg2xml | file</th>
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
            displayLength: 50,
            ajax: {
                url: "{{ route('template.getIndex') }}",
                type: "post"
            },
            columns: [
                {data: 'template'},
                {data: 'category'},
                {data: 'link'},
                {data: 'script'},
                {data: 'time_create'},
                {data: 'time_update'},
                {data: 'time_get'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
                { "orderable": false, "targets": [1,2,3] }
            ],
            order:[0,'asc']

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

<script>
    function editTemplate(id) {
        $.get('{{asset('template/edit')}}/'+id,function (data) {
            var text_ads_id = document.getElementById("ads_id");
            text_ads_id.style.display = "none";
            $("#Check_ads_id").prop('checked', false);
            var text_ads_banner = document.getElementById("banner");
            text_ads_banner.style.display = "none";
            $("#Check_ads_banner").prop('checked', false);
            var text_ads_inter= document.getElementById("ads_inter");
            text_ads_inter.style.display = "none";
            $("#Check_ads_inter").prop('checked', false);
            var text_ads_reward = document.getElementById("ads_reward");
            text_ads_reward.style.display = "none";
            $("#Check_ads_reward").prop('checked', false);
            var text_ads_native = document.getElementById("ads_native");
            text_ads_native.style.display = "none";
            $("#Check_ads_native").prop('checked', false);
            var text_ads_open = document.getElementById("ads_open");
            text_ads_open.style.display = "none";
            $("#Check_ads_open").prop('checked', false);


            if(data.ads != null){
                var ads = jQuery.parseJSON(data.ads);
                console.log(ads)
                if(ads.ads_id !=null){
                    text_ads_id.style.display = "block";
                    $('#ads_id').val(ads.ads_id);
                    $("#Check_ads_id").prop('checked', true);
                }else{
                    $("#Check_ads_id").prop('checked', false);
                    $('#ads_id').val('');
                }
                if(ads.ads_banner !=null){
                    text_ads_banner.style.display = "block";
                    $('#banner').val(ads.ads_banner);
                    $("#Check_ads_banner").prop('checked', true);
                }else{
                    $("#Check_ads_banner").prop('checked', false);
                    $('#banner').val('');
                }
                if(ads.ads_inter!=null){

                    text_ads_inter.style.display = "block";
                    $('#ads_inter').val(ads.ads_inter);
                    $("#Check_ads_inter").prop('checked', true);
                }else{
                    $("#Check_ads_inter").prop('checked', false);
                    $('#ads_inter').val('');
                }
                if(ads.ads_reward !=null){

                    text_ads_reward.style.display = "block";
                    $('#ads_reward').val(ads.ads_reward);
                    $("#Check_ads_reward").prop('checked', true);
                }else{
                    $("#Check_ads_reward").prop('checked', false);
                    $('#ads_reward').val('');
                }
                if(ads.ads_native !=null){

                    text_ads_native.style.display = "block";
                    $('#ads_native').val(ads.ads_native);
                    $("#Check_ads_native").prop('checked', true);
                }else{
                    $("#Check_ads_native").prop('checked', false);
                    $('#ads_native').val('');
                }
                if(ads.ads_open !=null){

                    text_ads_open.style.display = "block";
                    $('#ads_open').val(ads.ads_open);
                    $("#Check_ads_open").prop('checked', true);
                }else{
                    $("#Check_ads_open").prop('checked', false);
                    $('#ads_open').val('');
                }
            }
            $('#template_id').val(data.id);
            $('#template').val(data.template);
            $('#ver_build').val(data.ver_build);
            $('#script_copy').val(data.script_copy);
            $('#script_img').val(data.script_img);
            $('#script_svg2xml').val(data.script_svg2xml);
            $('#script_file').val(data.script_file);
            $('#permissions').val(data.permissions);
            $('#policy1').val(data.policy1);
            $('#policy2').val(data.policy2);
            $('#note').val(data.note);
            $('#link').val(data.link);
            $('#package').val(data.package);
            $('#convert_aab').val(data.convert_aab);
            $('#startus').val(data.startus);
            $('#link_store_vietmmo').val(data.link_store_vietmmo);
            $('#Chplay_category').val(data.Chplay_category);
            $('#Amazon_category').val(data.Amazon_category);
            $('#Samsung_category').val(data.Samsung_category);
            $('#Xiaomi_category').val(data.Xiaomi_category);
            $('#Oppo_category').val(data.Oppo_category);
            $('#Vivo_category').val(data.Vivo_category);

            $('#modelHeading').html("Edit");
            $('#saveBtn').val("edit-template");
            $('#ajaxModel').modal('show');
            $('.modal').on('hidden.bs.modal', function (e) {
                $('body').addClass('modal-open');
            });
        })
    }
    function myFunction() {
        var checkBox_ads_id= document.getElementById("Check_ads_id");
        var text_ads_id = document.getElementById("ads_id");
        if (checkBox_ads_id.checked == true){
            text_ads_id.style.display = "block";
        } else {
            text_ads_id.style.display = "none";
            $('#ads_id').val('');
        }

        var checkBox_ads_banner = document.getElementById("Check_ads_banner");
        var text_ads_banner = document.getElementById("banner");
        if (checkBox_ads_banner.checked == true){
            text_ads_banner.style.display = "block";
        } else {
            text_ads_banner.style.display = "none";
            $('#banner').val('');
        }

        var checkBox_ads_inter = document.getElementById("Check_ads_inter");
        var text_ads_inter = document.getElementById("ads_inter");
        if (checkBox_ads_inter.checked == true){
            text_ads_inter.style.display = "block";
        } else {
            text_ads_inter.style.display = "none";
            $('#ads_inter').val('');
        }

        var checkBox_ads_reward = document.getElementById("Check_ads_reward");
        var text_ads_reward = document.getElementById("ads_reward");
        if (checkBox_ads_reward.checked == true){
            text_ads_reward.style.display = "block";
        } else {
            text_ads_reward.style.display = "none";
            $('#ads_reward').val('');
        }

        var checkBox_ads_native = document.getElementById("Check_ads_native");
        var text_ads_native = document.getElementById("ads_native");
        if (checkBox_ads_native.checked == true){
            text_ads_native.style.display = "block";
        } else {
            text_ads_native.style.display = "none";
            $('#ads_native').val('');
        }

        var checkBox_ads_open = document.getElementById("Check_ads_open");
        var text_ads_open = document.getElementById("ads_open");
        if (checkBox_ads_open.checked == true){
            text_ads_open.style.display = "block";
        } else {
            text_ads_open.style.display = "none";
            $('#ads_open').val('');
        }
    }

</script>



@endsection






