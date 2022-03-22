<div class="modal fade" id="buildpreviewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buildpreviewModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form id="buildpreviewForm" name="buildpreviewForm" class="form-horizontal">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label for="name">Category Frame</label>
                            <select class="form-control select2" id="category_template_frame" name="category_template_frame">
{{--                                <option value="">--Vui lòng chọn--</option>--}}
                                @if(isset($categoyTemplateFrame))
                                    @foreach($categoyTemplateFrame as $item)
                                        <option value="{{$item->id}}">{{$item->category_template_frames_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="name">Template Frame Preview</label>
                            <select class="form-control select2" id="template_frame_preview" name="template_frame_preview">
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <p for="name"> Preview</p>
                            <img id="preview" class="thumbnail" width="200px">
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label for="name">Category Text</label>
                            <select class="form-control select2" id="category_template_text" name="category_template_text">
                                {{--                                <option value="">--Vui lòng chọn--</option>--}}
                                @if(isset($categoyTemplateText))
                                    @foreach($categoyTemplateText as $item)
                                        <option value="{{$item->id}}">{{$item->category_template_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="name">Template Text Preview</label>
                            <select class="form-control select2" id="template_text_preview" name="template_text_preview">
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <p for="name"> Preview</p>
                            <img id="preview" class="thumbnail" width="200px">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>


{{--<div class="modal fade bd-example-modal-xl" id="categoryTemplateChildModel" aria-hidden="true">--}}
{{--    <div class="modal-dialog">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h4 class="modal-title" id="childModalLabel">Thêm mới Category Template Child</h4>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                <form id="CategoryTemplateChildForm" name="CategoryTemplateChildForm" class="form-horizontal">--}}
{{--                    <input type="hidden" name="category_template_id" id="category_template_child_id">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="name">Category Parent</label>--}}
{{--                        <select class="form-control select2" id="category_template_parent_child" name="category_template_parent">--}}
{{--                            <option value="">--None--</option>--}}
{{--                            @if(isset($categoyTemplate))--}}
{{--                                @foreach($categoyTemplate as $item)--}}
{{--                                    <option value="{{$item->id}}">{{$item->category_template_name}}</option>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                        </select>--}}
{{--                    </div>--}}


{{--                    <div class="form-group">--}}
{{--                        <label for="name">Template Text <span style="color: red">*</span></label>--}}
{{--                        <input type="text" id="category_template_child_child" name="category_template_name" class="form-control" required>--}}
{{--                    </div>--}}
{{--                    <div class="col-sm-offset-2 col-sm-10">--}}
{{--                        <button type="submit" class="btn btn-primary" id="saveBtnChild">Save</button>--}}
{{--                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
