@extends('layouts.master')

@section('css')

    <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <style>
        .tooltip-inner {
            max-width: 1000px !important;
            text-align:left;
        }
    </style>



    <!-- Sweet-Alert  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


    <!-- Select2 Js  -->
    <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb')
    <div class="col-sm-6">
        <h4 class="page-title">Apk Process</h4>
    </div>
    <div class="col-sm-6">
        <div class="float">
{{--            <a class="btn btn-success" href="javascript:void(0)" id="createNewProfile"> Create New</a>--}}

        </div>
    </div>
    @include('modals.profile')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
{{--                <div class="card-body">--}}
{{--                    <div class="button-items">--}}
{{--                        @foreach($categories as $category)--}}
{{--                            <a href="{{route('apk_process.index',['id'=>$category['type'],'cate_id'=>$category['id']])}}" class="btn btn-light waves-effect"> {{$category['name']}}</a>--}}
{{--                            <button type="button" class="btn btn-light waves-effect" onclick="category('{{$category['id']}}')">{{$category['name']}}</button>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="card-body scrolling-pagination ">
                    <table class="table table-bordered dt-responsive data-table apk-process" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            {{--                            <th>Logo</th>--}}
                            <th>Logo</th>
                            <th style="width: 5px">Admob</th>
                            <th style="width: 5px">Facebook</th>
                            <th style="width: 5px">StartApp</th>
                            <th style="width: 5px">Huawei</th>
                            <th style="width: 5px">Iron</th>
                            <th style="width: 5px">Applovin</th>
                            <th style="width: 5px">Appbrain</th>
                            <th style="width: 5px">Unity3d</th>
                            <th style="width: 5px">Rebuild</th>
                            <th style="width: 5px">Aab</th>
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

{{--    <script type="text/javascript" src="https://cdn.datatables.net/scroller/2.0.6/js/dataTables.scroller.min.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>


    <script src="plugins/select2/js/select2.min.js"></script>

    <script type="text/javascript">
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.apk-process').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('apk_process.getIndex') }}",
                    type: "post"
                },
                columns: [
                    {data: 'icon'},
                    {data: 'pss_ads->Admob',"className": "text-center",},
                    {data: 'pss_ads->Facebook',"className": "text-center"},
                    {data: 'pss_ads->StartApp',"className": "text-center"},
                    {data: 'pss_ads->Huawei',"className": "text-center"},
                    {data: 'pss_ads->Iron',"className": "text-center"},
                    {data: 'pss_ads->Applovin',"className": "text-center"},
                    {data: 'pss_ads->Appbrain',"className": "text-center"},
                    {data: 'pss_ads->Unity3d',"className": "text-center"},
                    {data: 'pss_ads->Unity3d',"className": "text-center"},
                    {data: 'pss_ads->Unity3d',"className": "text-center"},
                ],
                {{--columnDefs: [--}}

                {{--    {--}}
                {{--        targets: 0,--}}
                {{--        orderable: false,--}}
                {{--        responsivePriority: 0,--}}
                {{--        render: function (data, type, full, meta) {--}}
                {{--            var $output ='<img src="{{asset('uploads/profile/logo')}}/'+data+'" alt="logo" height="100px">';--}}
                {{--            return $output;--}}
                {{--        }--}}
                {{--    },--}}
                {{--],--}}
                order:[0,'asc']
            });
            {{--var groupColumn = 0;--}}

            {{--var table = $('.data-table').DataTable({--}}
            {{--    processing: true,--}}
            {{--    serverSide: true,--}}
            {{--    ajax: {--}}
            {{--        url: "{{ route('profile.getIndex') }}",--}}
            {{--        type: "post"--}}
            {{--    },--}}
            {{--    columns: [--}}
            {{--        {data: 'ma_profile'},--}}
            {{--        {data: 'name_en'},--}}
            {{--        {data: 'mst'},--}}
            {{--        {data: 'dia_chi'},--}}
            {{--        {data: 'ngay_thanh_lap'},--}}
            {{--        {data: 'action', className: "text-center",name: 'action', orderable: false, searchable: false},--}}
            {{--    ],--}}
            {{--    rowGroup: {--}}
            {{--        dataSrc: 0--}}
            {{--    },--}}
            {{--    columnDefs: [{ visible: false, targets: groupColumn }],--}}
            {{--    drawCallback: function (settings) {--}}
            {{--        var api = this.api();--}}
            {{--        var rows = api.rows({ page: 'current' }).nodes();--}}
            {{--        var last = null;--}}

            {{--        api--}}
            {{--            .column(groupColumn, { page: 'current' })--}}
            {{--            .data()--}}
            {{--            .each(function (group, i) {--}}
            {{--                if (last !== group) {--}}
            {{--                    $(rows)--}}
            {{--                        .eq(i)--}}
            {{--                        .before('<tr class="group"><td colspan="5">' + group + '</td></tr>');--}}

            {{--                    last = group;--}}
            {{--                }--}}
            {{--            });--}}
            {{--    },--}}

            {{--});--}}
            {{--// $('.data-table tbody').on('click', 'tr.group', function () {--}}
            {{--//     var currentOrder = table.order()[0];--}}
            {{--//     if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {--}}
            {{--//         table.order([groupColumn, 'desc']).draw();--}}
            {{--//     } else {--}}
            {{--//         table.order([groupColumn, 'asc']).draw();--}}
            {{--//     }--}}
            {{--// });--}}






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
@endsection






