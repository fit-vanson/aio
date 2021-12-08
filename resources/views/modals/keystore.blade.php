
<div class="modal fade bd-example-modal-xl" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="keystoreForm" name="keystoreForm" class="form-horizontal">
                    <div data-repeater-item="" class="row">
                        <div class="form-group col-lg-6 ">
{{--                            <label for="name">Tên Keystore</label>--}}
{{--                            <input type="text" class="form-control" id="name_keystore" name="name_keystore" required>--}}
                            <div class="fallback">
                                <input name="keystore_file" id="keystore_file" type="file"  multiple="multiple">
                            </div>
                        </div>
                        <div class="form-group col-lg-6 ">
                            <label for="name">Tên Keystore</label>
                            <input type="hidden" name="keystore_id" id="keystore_id">
                            <input type="text" class="form-control" id="name_keystore" name="name_keystore" required>
                        </div>

                    </div>

                    <div data-repeater-item="" class="row">
                        <div class="form-group col-lg-6 ">
                            <label for="name">Pass Keystore</label>
                            <input type="text" id="pass_keystore" name="pass_keystore" class="form-control" >
                        </div>
                        <div class="form-group col-lg-6 ">
                            <label for="name">Aliases Keystore</label>
                            <input type="text" id="aliases_keystore" name="aliases_keystore" class="form-control" >
{{--                            <textarea id="aliases_keystore" name="aliases_keystore" class="form-control" rows="4" ></textarea>--}}
                        </div>

                    </div>
                    <div data-repeater-item="" class="row">
                        <div class="form-group col-lg-6">
                            <label for="name">SHA_256 Keystore</label>
                            <textarea id="SHA_256_keystore" name="SHA_256_keystore" class="form-control" rows="4" ></textarea>
                        </div>
                        <div class="form-group col-lg-6 ">
                            <label for="name">Ghi chú</label>
                            <textarea id="note" name="note" class="form-control" rows="4" ></textarea>
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







