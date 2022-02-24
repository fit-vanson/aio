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
        <h4 class="page-title">Quản lý Profile</h4>
    </div>
    <div class="col-sm-6">
        <div class="float-right">
            <a class="btn btn-success" href="javascript:void(0)" id="createNewProfile"> Create New</a>
        </div>
    </div>
    @include('modals.profile')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table class="table table-bordered dt-responsive nowrap data-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>CCCD/CMND </th>
                            <th>File </th>
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
                    url: "{{ route('profile.getIndex') }}",
                    type: "post"
                },
                columns: [
                    {data: 'profile_logo'},
                    {data: 'profile_name'},
                    {data: 'profile_sdt'},
                    {data: 'profile_dia_chi'},
                    {data: 'profile_cccd'},
                    {data: 'profile_file'},
                    {data: 'action', className: "text-center",name: 'action', orderable: false, searchable: false},
                ],
                columnDefs: [

                    {
                        targets: 0,
                        orderable: false,
                        responsivePriority: 0,
                        render: function (data, type, full, meta) {
                            var $output ='<img src="{{asset('uploads/profile/logo')}}/'+data+'" alt="logo" height="100px">';
                            return $output;
                        }
                    },

                ],
                order:[1,'asc']
            });
            $('#createNewProfile').click(function () {
                $('#saveBtn').val("create");
                $('#id').val('');
                $('#ProfileForm').trigger("reset");
                $('#modelHeading').html("Thêm mới");
                $('#ajaxModelProfile').modal('show');
            });
            $('#ProfileForm').on('submit',function (event){
                event.preventDefault();
                var formData = new FormData($("#ProfileForm")[0]);
                if($('#saveBtn').val() == 'create'){
                    $.ajax({
                        data: formData,
                        url: "{{ route('profile.create') }}",
                        type: "POST",
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            if(data.errors){
                                for( var count=0 ; count <data.errors.length; count++){
                                    $("#ProfileForm").notify(
                                        data.errors[count],"error",
                                        { position:"right" }
                                    );
                                }
                            }
                            if(data.success){
                                $.notify(data.success, "success");
                                $('#ProfileForm').trigger("reset");
                                $('#ajaxModelProfile').modal('hide');
                                table.draw();
                            }
                        },
                    });
                }
                if($('#saveBtn').val() == 'edit-dev'){
                    $.ajax({
                        data: formData,
                        url: "{{ route('profile.update') }}",
                        type: "post",
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            if(data.errors){
                                for( var count=0 ; count <data.errors.length; count++){
                                    $("#ProfileForm").notify(
                                        data.errors[count],"error",
                                        { position:"right" }
                                    );
                                }
                            }
                            if(data.success){
                                $.notify(data.success, "success");
                                $('#ProfileForm').trigger("reset");
                                $('#ajaxModelProfile').modal('hide');
                                table.draw();
                            }
                        },
                    });
                }

            });
            $(document).on('click','.deleteProfile', function (data){
                var id = $(this).data("id");

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
                            url: "{{ asset("profile/delete") }}/" + id,
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
        function editProfile(id) {
            $.get('{{asset('profile/edit')}}/'+id,function (data) {
                $('#Profile_id').val(data.id);
                $('#profile_cccd').val(data.profile_cccd);
                $('#profile_dia_chi').val(data.profile_dia_chi);
                $('#profile_name').val(data.profile_name);
                $('#profile_ho_ten').val(data.profile_ho_ten);
                $('#profile_note').val(data.profile_note);
                $('#profile_sdt').val(data.profile_sdt);
                {{--$('#profile_file').val('{{asset('uploads/profile/')}}/'+data.profile_file);--}}
                $('#avatar').attr('src','{{asset('uploads/profile/logo')}}/'+data.profile_logo);

                if(data.profile_anh_cccd !=0){
                    $("#profile_anh_cccd").prop('checked', true);
                }else{
                    $("#profile_anh_cccd").prop('checked', false);
                }

                if(data.profile_anh_ngan_hang !=0){
                    $("#profile_anh_ngan_hang").prop('checked', true);

                }else{
                    $("#profile_anh_ngan_hang").prop('checked', false);
                }

                if(data.profile_anh_bang_lai !=0){
                    $("#profile_anh_bang_lai").prop('checked', true);

                }else{
                    $("#profile_anh_bang_lai").prop('checked', false);
                }




                $('#modelHeading').html("Edit");
                $('#saveBtn').val("edit-dev");
                $('#ajaxModelProfile').modal('show');
                $('.modal').on('hidden.bs.modal', function (e) {
                    $('body').addClass('modal-open');
                });
            })
        }
    </script>

@endsection





