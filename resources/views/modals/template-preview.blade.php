
<div class="modal fade bd-example-modal-xl" id="template_previewModel" aria-hidden="true">
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
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">Tên Template <span style="color: red">*</span></label>
                                <input type="text" id="tp_name" name="tp_name" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="name">File SC</label><p></p>
                                <input type="file" name="tp_sc" id="tp_sc" class="filestyle" data-buttonname="btn-secondary" accept=".zip" />
                            </div>
                        </div>
                        <div data-repeater-item="" class="row">
                            <?php
                            for ($i = 1; $i<=8 ;$i++){
                            ?>
                                <div class="form-group col-lg-6 ">
                                    <label for="name">SCRIPT {{$i}} </label>
                                    <textarea id="tp_script_{{$i}}" name="tp_script_{{$i}}" class="form-control" rows="4" ></textarea>
                                </div>
                            <?php }?>
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




