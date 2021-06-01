
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="roleForm" name="roleForm" class="form-horizontal">
                    <input type="hidden" name="role_id" id="role_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-5 control-label">Tên Vai trò</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"  >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-5 control-label">Mô tả vai trò</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="display_name" name="display_name">
                        </div>
                    </div>


                    @foreach($permissionParent as $per)

                    <div class="form-group card border-primary mb3 col-md-12 checkbox">
                        <div class="card-header">
                            <laber>
                                <input class="checkbox_All" type="checkbox" value="{{$per->id}}">
                            </laber> {{$per->display_name}}
                        </div>
                        <div class="row">
                            @foreach($per->permissionChild as $item)
                            <div class="card-body text-primary col-md-3">
                                <h6 class="card-title">
                                    <laber>
                                        <input class="checkbox_Child" id="permission_id_{{$item->id}}"
                                               {{$permissionOfRole->contains('id',$item->id) ?  'checked' : ''}}
                                               name="permission_id[]" type="checkbox" value="{{$item->id}}">
                                    </laber> {{$item->display_name}}
                                </h6>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach






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

