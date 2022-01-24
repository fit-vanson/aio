
<div class="modal fade bd-example-modal-xl" id="ajaxModelProfile" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="ProfileForm" name="ProfileForm" class="form-horizontal">
                    <input type="hidden" name="Profile_id" id="Profile_id">
                    <div data-repeater-list="group-a">
                        <div data-repeater-item="" class="row">


                            <div class="form-group col-lg-4">
                                <label for="name">Logo</label>
                                <input  id="logo" type="file" name="logo" class="form-control" hidden onchange="changeImg(this)" accept="image/png, image/jpeg">
                                <img id="avatar" class="thumbnail" width="100px" src="img/logo.png">
                            </div>

                            <div class="form-group col-lg-4">
                                <input type="file" name="profile_file" id="profile_file" class="filestyle" data-buttonname="btn-secondary" accept=".zip,.rar,.7zip" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="name">File đính kèm chứa</label>
                                <div class="checkbox-group required">
                                    <input type="checkbox" name="profile_anh_cccd" id="profile_anh_cccd" required> : CCCD<br>
                                    <input type="checkbox" name="profile_anh_bang_lai" id="profile_anh_bang_lai" required> : Bằng lái xe<br>
                                    <input type="checkbox" name="profile_anh_ngan_hang" id="profile_anh_ngan_hang" required> :Thẻ Ngân hàng
                                </div>
                            </div>

                        </div>
                        <div data-repeater-item="" class="row">

                            <div class="form-group col-lg-6">
                                <label for="name">Name  <span style="color: red">*</span></label>
                                <input type="text" id="profile_name" name="profile_name" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="name">CCCD/CMND </label>
                                <input type="text" id="profile_cccd" name="profile_cccd" class="form-control" required>
                            </div>
                        </div>
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">SĐT</label>
                                <input type="text" id="profile_sdt" name="profile_sdt" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="name">Địa chỉ</label>
                                <input type="text" id="profile_dia_chi" name="profile_dia_chi" class="form-control" required>
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





