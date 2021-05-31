
<div class="modal fade bd-example-modal-xl" id="ajaxModelDev" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form id="devForm" name="devForm" class="form-horizontal">
                    <input type="hidden" name="dev_id" id="dev_id">

                    <div data-repeater-list="group-a">
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">Tên  <span style="color: red">*</span></label>
                                <input type="text" id="store_name" name="store_name" class="form-control" required>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="name">Email <span style="color: red">*</span></label>
                                <div class="inner row">
                                    <div class="col-md-10 col-10">
                                        <select class="form-control select2js" id="gmail_gadev_chinh" name="gmail_gadev_chinh">
                                            <option>---Vui lòng chọn---</option>
                                            @foreach($ga_dev as $item)
                                                <option value="{{$item->id}}">{{$item->gmail}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-4">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addGaDev" style="border-radius: 0 3px 3px 0; box-shadow: none;">...
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">Email 1</label>
                                <div class="inner row">
                                    <div class="col-md-12 col-12">
                                        <select class="form-control select2js" id="gmail_gadev_phu_1" name="gmail_gadev_phu_1">
                                            <option>---Vui lòng chọn---</option>
                                            @foreach($dev as $item)
                                                <option value="{{$item->id}}">{{$item->gmail}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="name">Email 2</label>
                                <div class="inner row">
                                    <div class="col-md-12 col-12">
                                        <select class="form-control select2js" id="gmail_gadev_phu_2" name="gmail_gadev_phu_2">
                                            <option>---Vui lòng chọn---</option>
                                            @foreach($dev as $item)
                                                <option value="{{$item->id}}">{{$item->gmail}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6 ">
                                <label for="name">Số điện thoại</label>
                                <input type="text" id="info_phone" name="info_phone" class="form-control">
                            </div>

                            <div class="form-group col-lg-6 ">
                                <label for="name">Địa chỉ</label>
                                <input type="text" id="info_andress" name="info_andress" class="form-control">
                            </div>
                        </div>
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">Đường dẫn</label>
                                <input type="url" id="info_url" name="info_url" class="form-control">
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="name">Logo</label>
                                <input type="url" id="info_logo" name="info_logo" class="form-control">
                            </div>
                        </div>

                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6 ">
                                <label for="name">Banner</label>
                                <input type="url" id="info_banner" name="info_banner" class="form-control">
                            </div>

                            <div class="form-group col-lg-6 ">
                                <label for="name">Policy</label>
                                <input type="url" id="info_policydev" name="info_policydev" class="form-control">
                            </div>
                        </div>
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6 ">
                                <label for="name">Fanpage</label>
                                <input type="url" id="info_fanpage" name="info_fanpage" class="form-control">
                            </div>

                            <div class="form-group col-lg-6 ">
                                <label for="name">Policy</label>
                                <input type="url" id="info_web" name="info_web" class="form-control">
                            </div>
                        </div>
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">Trạng thái </label>
                                <div class="inner row">
                                    <div class="col-md-12 col-12">
                                        <select class="form-control ma_da" id="status" name="status">
                                            <option value="0">Chưa sử dụng</option>
                                            <option value="1">Đang phát triển</option>
                                            <option value="2">Đóng</option>
                                            <option value="3">Suspend</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addGaDev" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm mới Tài khoản</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form id="addGaDevForm" name="addDevForm" class="form-horizontal">
                    <input type="hidden" name="gadev_id" id="gadev_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-5 control-label">Gmail</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="gmail" name="gmail" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-5 control-label">Email Recover</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="mailrecovery" name="mailrecovery">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">VPN</label>
                        <div class="col-sm-12">
                            <input type="text" id="vpn_iplogin" class="form-control" name="vpn_iplogin">
                        </div>
                    </div>
                    <div class="form-group input_note">
                        <label class="col-sm-5 control-label">Ghi chú</label>
                        <div class="col-sm-12">
                            <textarea id="note" name="note" class="form-control" rows="4" ></textarea>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" value="create">Save changes
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>




