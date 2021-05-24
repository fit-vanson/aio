<!-- Modal Infor -->

<div class="modal fade" id="viewInforUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Thông tin User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr style=" text-align: center;">
                                        <th>STT</th>
                                        <th>Ảnh đã xem</th>
                                        <th>Hệ điều hành</th>
                                        <th>Trình duyệt</th>
                                        <th>Công cụ</th>
                                        <th>Truy cập cuối</th>
                                        <th>Số lần truy cập</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; ?>
{{--                                    @foreach( $list as $item)--}}
{{--                                        <tr>--}}
{{--                                            <td style=" text-align: center;"><?= $i ?></td>--}}
{{--                                            --}}{{--                                <td>{{$item->user_view_ip_image}}</td>--}}
{{--                                            <td >--}}
{{--                                                <img height="100px" width="100px" src="{{asset('public/uploads/'.$item->image_name)}}">--}}

{{--                                            </td>--}}
{{--                                            <td>{{$item->user_view_os}}</td>--}}
{{--                                            <td>{{$item->user_view_browser}}</td>--}}
{{--                                            <td>{{$item->user_view_device}}</td>--}}
{{--                                            <td>{{$item->updated_at}}</td>--}}
{{--                                            <td>{{$item->count}}</td>--}}
{{--                                        </tr>--}}
                                        <?php $i++ ?>
{{--                                    @endforeach--}}
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
        </div><!-- /.modal-content -->
    </div>
</div>

