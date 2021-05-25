
<div class="modal fade bd-example-modal-xl" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog" id="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">

                <form id="gadevForm" name="gadevForm" class="form-horizontal">
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

                    <div data-repeater-list="group-a" class="input_bk">
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6">
                                <label class="col-sm-5 control-label">BK1</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="bk_1" name="bk_1">
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="col-sm-5 control-label">BK2</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="bk_2" name="bk_2">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div data-repeater-list="group-a" class="input_bk">
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6">
                                <label class="col-sm-5 control-label">BK3</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="bk_3" name="bk_3">
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="col-sm-5 control-label">BK4</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="bk_4" name="bk_4">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-repeater-list="group-a" class="input_bk">
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6">
                                <label class="col-sm-5 control-label">BK5</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="bk_5" name="bk_5">
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="col-sm-5 control-label">BK6</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="bk_6" name="bk_6">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-repeater-list="group-a" class="input_bk">
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6">
                                <label class="col-sm-5 control-label">BK7</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="bk_7" name="bk_7">
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="col-sm-5 control-label">BK8</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="bk_8" name="bk_8">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-repeater-list="group-a" class="input_bk">
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6">
                                <label class="col-sm-5 control-label">BK9</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="bk_9" name="bk_9">
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="col-sm-5 control-label">BK10</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="bk_10" name="bk_10">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group input_note">
                        <label class="col-sm-5 control-label">Ghi chú</label>
                        <div class="col-sm-12">
                            <textarea id="note" name="note" class="form-control" rows="4" ></textarea>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




