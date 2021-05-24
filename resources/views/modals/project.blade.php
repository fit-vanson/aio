
<div class="modal fade bd-example-modal-xl" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">

                <form id="projectForm" name="projectForm" class="form-horizontal">
                    <input type="hidden" name="project_id" id="project_id">
                    <div data-repeater-list="group-a">
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6 input_ma_da">
                                <label for="name">Mã dự án <span style="color: red">*</span></label>
                                <input type="text" id="ma_da" name="ma_da" class="form-control" required>
                            </div>
                        </div>
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6 input_projectname">
                                <label for="name">Tên Project <span style="color: red">*</span></label>
                                <input type="text" id="projectname" name="projectname" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6 input_template">
                                <label for="name">Tên template <span style="color: red">*</span></label>
                                <input type="text" id="template" name="template" class="form-control" required >
                            </div>
                        </div>


                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6 input_package">
                                <label for="name">Tên Package </label>
                                <input type="text" id="package" name="package" class="form-control">
                            </div>
                            <div class="form-group col-lg-6 input_title_app">
                                <label for="name">Tiêu đề ứng dụng  <span style="color: red">*</span></label>
                                <input type="text" id="title_app" name="title_app" class="form-control" required >
                            </div>
                        </div>

                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">Version Number <span style="color: red">*</span></label>
                                <input type="number" id="buildinfo_vernum" name="buildinfo_vernum" class="form-control" required >
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="name">Version String<span style="color: red">*</span></label>
                                <input type="text" id="buildinfo_verstr" name="buildinfo_verstr" class="form-control" required >
                            </div>
                        </div>

                        <div data-repeater-item="" class="row input_buildinfo">
                            <div class="form-group col-lg-6">
                                <label for="name">App Name</label>
                                <input type="text" id="buildinfo_app_name_x" name="buildinfo_app_name_x" class="form-control" >
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="name">Store Name </label>
                                <input type="text" id="buildinfo_store_name_x" name="buildinfo_store_name_x" class="form-control" >
                            </div>
                        </div>

                        <div data-repeater-item="" class="row input_buildinfo">
                            <div class="form-group col-lg-6 ">
                                <label for="name">Link Policy</label>
                                <input type="text" id="buildinfo_link_policy_x" name="buildinfo_link_policy_x" class="form-control" >
                            </div>
                            <div class="form-group col-lg-6 ">
                                <label for="name">Link Fanpage </label>
                                <input type="text" id="buildinfo_link_fanpage" name="buildinfo_link_fanpage" class="form-control" >
                            </div>
                        </div>

                        <div data-repeater-item="" class="row input_buildinfo">
                            <div class="form-group col-lg-6 ">
                                <label for="name">Link Website</label>
                                <input type="text" id="buildinfo_link_fanpage" name="buildinfo_link_website" class="form-control" >
                            </div>
                            <div class="form-group col-lg-6 ">
                                <label for="name">Link Store </label>
                                <input type="text" id="buildinfo_link_store" name="buildinfo_link_store" class="form-control" >
                            </div>
                        </div>

                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6 input_buildinfo_keystore">
                                <label for="name">Keystore Profile</label>
                                <input type="text" id="buildinfo_keystore" name="buildinfo_keystore" class="form-control" >
                            </div>
                            <div class="form-group col-lg-6 input_buildinfo_console">
                                <label for="name">Trạng thái</label>
                                <div>
                                    <select class="form-control" id="buildinfo_console" name="buildinfo_console">
                                        <option value="0">Mặc định</option>
                                        <option value="1">Public</option>
                                        <option value="2">Remove</option>
                                        <option value="3">Reject</option>
                                        <option value="4">Suspend</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div data-repeater-item="" class="row input_ads">
                            <div class="form-group col-lg-4">
                                <label for="name">Ads ID</label>
                                <input type="text" id="ads_id" name="ads_id" class="form-control" >
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="name">Ads Banner:</label>
                                <input type="text" id="banner" name="banner" class="form-control" >
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="name">Ads Inter</label>
                                <input type="text" id="ads_inter" name="ads_inter" class="form-control" >
                            </div>
                        </div>

                        <div data-repeater-item="" class="row input_ads">
                            <div class="form-group col-lg-4">
                                <label for="name">Ads Reward</label>
                                <input type="text" id="ads_reward" name="ads_reward" class="form-control" >
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="name">Ads Native</label>
                                <input type="text" id="ads_native" name="ads_native" class="form-control" >
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="name">Ads Open</label>
                                <input type="text" id="ads_open" name="ads_open" class="form-control" >
                            </div>
                        </div>
                        <div data-repeater-item="" class="row input_api" >
                            <div class="form-group col-lg-4">
                                <label for="name">buildinfo_time</label>
                                <input disabled type="number" id="buildinfo_time" name="buildinfo_time" class="form-control" >
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="name">buildinfo_mess</label>
                                <input disabled type="number" id="buildinfo_mess" name="buildinfo_mess" class="form-control" >
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="name">time_mess</label>
                                <input disabled type="text" id="time_mess" name="time_mess" class="form-control" >
                            </div>
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


<div class="modal fade bd-example-modal-xl" id="ajaxQuickModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelQuickHeading"></h4>
            </div>
            <div class="modal-body">

                <form id="projectQuickForm" name="projectQuickForm" class="form-horizontal">
                    <input type="hidden" name="project_id" id="quick_project_id">
                    <input type="hidden" name="projectname" id="quick_projectname">
                    <input type="hidden" name="ma_da" id="quick_ma_da">
                    <input type="hidden" name="template" id="quick_template">
                    <input type="hidden" name="package" id="quick_package">
                    <input type="hidden" name="title_app" id="quick_title_app">
                    <input type="hidden" name="buildinfo_app_name_x" id="quick_buildinfo_app_name_x">
                    <input type="hidden" name="buildinfo_store_name_x" id="quick_buildinfo_store_name_x">
                    <input type="hidden" name="buildinfo_link_policy_x" id="quick_buildinfo_link_policy_x">
                    <input type="hidden" name="buildinfo_link_fanpage" id="quick_buildinfo_link_fanpage">
                    <input type="hidden" name="buildinfo_link_website" id="quick_buildinfo_link_website">
                    <input type="hidden" name="buildinfo_link_store" id="quick_buildinfo_link_store">
                    <input type="hidden" name="buildinfo_keystore" id="quick_buildinfo_keystore">
                    <input type="hidden" name="ads_id" id="quick_ads_id">
                    <input type="hidden" name="banner" id="quick_ads_banner">
                    <input type="hidden" name="ads_inter" id="quick_ads_inter">
                    <input type="hidden" name="ads_reward" id="quick_ads_reward">
                    <input type="hidden" name="ads_native" id="quick_ads_native">
                    <input type="hidden" name="ads_open" id="quick_ads_open">
                    <input type="hidden" name="buildinfo_time" id="quick_buildinfo_time">
                    <input type="hidden" name="buildinfo_mess" id="quick_buildinfo_mess">
                    <input type="hidden" name="time_mess" id="quick_ads_time_mess">

                    <div class="form-group">
                        <label for="name" class="col-sm-5 control-label">Version Number</label>
                        <div class="col-sm-12">
                            <input type="number" id="quick_buildinfo_vernum" name="buildinfo_vernum" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-5 control-label">Version String</label>
                        <div class="col-sm-12">
                            <input type="text" id="quick_buildinfo_verstr" name="buildinfo_verstr" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-5 control-label">Trạng thái</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="quick_buildinfo_console" name="buildinfo_console">
                                <option value="0">Mặc định</option>
                                <option value="1">Public</option>
                                <option value="2">Remove</option>
                                <option value="3">Reject</option>
                                <option value="4">Suspend</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveQBtn" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

