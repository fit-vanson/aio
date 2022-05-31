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
                <div class="card-body">
                    <div class="button-items">
                        @foreach($categories as $category)
                            <button type="button" class="btn btn-light waves-effect" onclick="category('{{$category->id}}')">{{$category->name}}</button>
                        @endforeach
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered dt-responsive data-table apk-process" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Logo</th>
                            <th style="width: 10%">Logo</th>
                            <th style="width: 50%">Preview</th>
                            <th style="word-wrap: break-word;width: 30%">Description</th>
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
            var table = $('.apk-process').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('apk_process.getIndex',['id'=>$category->id])}}",
                    type: "post"
                },
                columns: [
                    {data: 'appid'},
                    {data: 'icon',"width": "10%"},
                    {data: 'screenshot',"width": "50%"},
                    {data: 'description' ,"width": "30%"},
                    {data: 'action', className: "text-center",name: 'action', orderable: false, searchable: false},
                ],
                columnDefs: [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    },
                ],
                order:[1,'asc']
            });
            $(document).on('click','.deleteApk_process', function (data){
                var id = $(this).data("id");
                var parent = $(this).parent().parent();
                $.ajax({
                    type: "get",
                    url: "{{ asset("apk_process/delete") }}/" + id,
                    success: function (data) {
                        if(data.success){
                            parent.slideUp(300,function() {
                                parent.remove();
                            })
                        }
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });

            });


            $(document).on('click','.actionApk_process', function (data){
                var id = $(this).data("id");
                var btn = $(this).parent();
                console.log(btn)

                $.ajax({
                    type: "get",
                    url: "{{ asset("apk_process/update_pss") }}/" + id,
                    success: function (data) {
                        console.log(parent);
                        if(data.success){
                           var  html = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'+id+'" data-original-title="Delete" class="btn btn-danger deleteApk_process"><i class="ti-trash"></i></a> <span class="btn btn-info">Xử lý</i></span>';
                            btn.html(html)
                        }
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });

            });
            $(document).on("click", ".button", function(){
                var copyText = this.innerText;
                var textarea = document.createElement('textarea');
                textarea.id = 'temp_element';
                textarea.style.height = 0;
                document.body.appendChild(textarea);
                textarea.value = copyText;
                var selector = document.querySelector('#temp_element')
                selector.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
            });
        });

        function category(id){
            var aa=  $('.data-table').DataTable({
                processing: false,
                serverSide: true,

                ajax: {
                    url: "{{ route('apk_process.getIndex')}}?id="+id,
                    type: "post"
                },
                columns: [
                    {data: 'appid'},
                    {data: 'icon',"width": "10%"},
                    {data: 'screenshot',"width": "50%"},
                    {data: 'description' ,"width": "30%"},
                    {data: 'action', className: "text-center",name: 'action', orderable: false, searchable: false},
                ],
                columnDefs: [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    },
                ],
                order:[1,'asc'],
                stateSave: true,
                "bDestroy": true,
            });



        }
    </script>

@endsection






