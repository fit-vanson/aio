
<div class="modal fade bd-example-modal-xl" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="templatePreviewForm" name="templatePreviewForm" enctype="multipart/form-data" class="form-horizontal">
                    <input type="hidden" name="tp_id" id="tp_id">

                    <div>
{{--                        <div data-repeater-item="" class="row">--}}
{{--                            <div class="form-group col-lg-3">--}}
{{--                                <label>Logo</label>--}}
{{--                                <input  id="logo" type="file" name="logo" class="form-control" hidden onchange="changeImg(this)" accept="image/*">--}}
{{--                                <img id="avatar" class="thumbnail" width="100px" src="img/logo.png">--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-lg-3">--}}
{{--                                <label for="name">DATA</label><p></p>--}}
{{--                                <input type="file" name="template_data" id="template_data" class="filestyle" data-buttonname="btn-secondary" accept=".zip">--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-lg-3">--}}
{{--                                <label for="name">APK</label><p></p>--}}
{{--                                <input type="file" name="template_apk" id="template_apk" class="filestyle" data-buttonname="btn-secondary" accept=".apk">--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-lg-3 ">--}}
{{--                                <label for="name">Tên Template</label>--}}
{{--                                <input type="text" id="template_name" name="template_name" class="form-control">--}}
{{--                            </div>--}}

{{--                        </div>--}}
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">Tên Template <span style="color: red">*</span></label>
                                <input type="text" id="tp_name" name="tp_name" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6 ">
                                <label for="name">Number SC</label>
                                <input type="number" id="tp_number" name="tp_number" class="form-control" required>
                            </div>
                        </div>
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-4">
                                <label for="name">File SC</label><p></p>
                                <input type="file" name="tp_sc" id="tp_sc" class="filestyle" data-buttonname="btn-secondary" accept=".zip" />
                            </div>
                            <div class="form-group col-lg-4 ">
                                <label for="name">Size</label>
                                <input type="text" id="tp_size" name="tp_size" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-4 ">
                                <label for="name">Start</label>
                                <input type="text" id="tp_start" name="tp_start" class="form-control" required>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




