
<div class="modal fade bd-example-modal-xl" id="template_text_previewModel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="templateTextPreviewForm" name="templateTextPreviewForm" enctype="multipart/form-data" class="form-horizontal">
                    <input type="hidden" name="tt_id" id="tt_id">

                    <div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">Tên Template Text <span style="color: red">*</span></label>
                                <input type="text" id="tt_name" name="tt_name" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="name">File SC</label><p></p>
                                <input type="file" name="tt_file" id="tt_file" class="filestyle" data-buttonname="btn-secondary" accept=".zip" />
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




