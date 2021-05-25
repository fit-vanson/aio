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
        <h4 class="page-title">Quản lý GaDev</h4>
    </div>
    <div class="col-sm-6">
        <div class="float-right">
            <a class="btn btn-success" href="javascript:void(0)" id="createNewGadev"> Create New</a>
        </div>
    </div>
    @include('modals.gadev')
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
                            <th>STT</th>
                            <th>Gmail</th>
                            <th>Gmail Recover</th>
                            <th>VPN</th>
                            <th>BK1</th>
                            <th>BK2</th>
                            <th>BK3</th>
                            <th>BK4</th>
                            <th>BK5</th>
                            <th>BK6</th>
                            <th>BK7</th>
                            <th>BK8</th>
                            <th>BK9</th>
                            <th>BK10</th>
                            <th>Ghi chú</th>
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
                ajax: "{{ route('gadev.index') }}",
                columns: [
                    { "data": null,"sortable": true,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'gmail'},
                    {data: 'mailrecovery'},
                    {data: 'vpn_iplogin'},
                    {data: 'bk1'},
                    {data: 'bk2'},
                    {data: 'bk3'},
                    {data: 'bk4'},
                    {data: 'bk5'},
                    {data: 'bk6'},
                    {data: 'bk7'},
                    {data: 'bk8'},
                    {data: 'bk9'},
                    {data: 'bk10'},
                    {data: 'note'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],


            });

            $('#createNewGadev').click(function () {
                $('#saveBtn').val("create-gedev");
                $('#gedev_id').val('');
                $('#gadevForm').trigger("reset");
                $('#modelHeading').html("Thêm mới");
                $('#ajaxModel').modal('show');
                $('.input_note').hide();
                $('.input_bk').hide();

            });
            $('#gadevForm').on('submit',function (event){
                event.preventDefault();
                if($('#saveBtn').val() == 'create-gedev'){
                    $.ajax({
                        data: $('#gadevForm').serialize(),
                        url: "{{ route('gadev.create') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            if(data.errors){
                                for( var count=0 ; count <data.errors.length; count++){
                                    $("#gadevForm").notify(
                                        data.errors[count],"error",
                                        { position:"right" }
                                    );
                                }
                            }
                            if(data.success){
                                $.notify(data.success, "success");
                                $('#gadevForm').trigger("reset");
                                $('#ajaxModel').modal('hide');
                                table.draw();
                            }
                        },
                    });
                }
                if($('#saveBtn').val() == 'edit-gedev'){
                    $.ajax({
                        data: $('#gadevForm').serialize(),
                        url: "{{ route('gadev.update') }}",
                        type: "post",
                        dataType: 'json',
                        success: function (data) {
                            if(data.errors){
                                for( var count=0 ; count <data.errors.length; count++){
                                    $("#gadevForm").notify(
                                        data.errors[count],"error",
                                        { position:"right" }
                                    );
                                }
                            }
                            if(data.success){
                                $.notify(data.success, "success");
                                $('#gadevForm').trigger("reset");
                                $('#ajaxModel').modal('hide');
                                table.draw();
                            }
                        },
                    });

                }

            });
            $(document).on('click','.editGadev', function (data){
                var gadev_id = $(this).data('id');
                someElement= document.getElementById("modal-dialog");
                someElement.className += " modal-xl";
                $('#modelHeading').html("Edit");
                $('#saveBtn').val("edit-gedev");
                $('#ajaxModel').modal('show');
                $('.input_note').show();
                $('.input_bk').show();



                $.ajax({
                    data: $('#gadevForm').serialize(),
                    url: "{{ asset("ga_dev/edit") }}/" + gadev_id,
                    type: "get",
                    dataType: 'json',
                    success: function (data) {
                        $('#gadev_id').val(data.gmail);
                        $('#gmail').val(data.gmail);
                        $('#mailrecovery').val(data.mailrecovery);
                        $('#vpn_iplogin').val(data.vpn_iplogin);
                        $('#note').val(data.note);
                        $('#bk_1').val(data.bk_1);
                        $('#bk_2').val(data.bk_2);
                        $('#bk_3').val(data.bk_3);
                        $('#bk_4').val(data.bk_4);
                        $('#bk_5').val(data.bk_5);
                        $('#bk_6').val(data.bk_6);
                        $('#bk_7').val(data.bk_7);
                        $('#bk_8').val(data.bk_8);
                        $('#bk_9').val(data.bk_9);
                        $('#bk_10').val(data.bk_10);
                    }
                });

            });

            $(document).on('click','.deleteGadev', function (data){
                var gadev_id = $(this).data("id");

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
                            url: "{{ asset("ga_dev/delete") }}/" + gadev_id,
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






