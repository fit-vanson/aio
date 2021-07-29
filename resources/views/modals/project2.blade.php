
<div class="modal fade bd-example-modal-xl" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="projectForm2" name="projectForm2" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="project_id" id="project_id">
                    <input type="hidden" name="buildinfo_console" id="buildinfo_console">
                    <div class="form-group col-lg-4">
                        <label>Logo</label>
                        <input  id="logo" type="file" name="logo" class="form-control" hidden onchange="changeImg(this)">
                        <img id="avatar" class="thumbnail" width="100px" src="img/logo.png">
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">
                                                <span class="d-none d-sm-block">Home</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#chplay" role="tab">
                                                <span class="d-none d-sm-block">CH Play</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#amazon" role="tab">
                                                <span class="d-none d-sm-block">Amazon</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#samsung" role="tab">
                                                <span class="d-none d-sm-block">SamSung</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#xiaomi" role="tab">
                                                <span class="d-none d-sm-block">Xiaomi</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#oppo" role="tab">
                                                <span class="d-none d-sm-block">Oppo</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#vivo" role="tab">
                                                <span class="d-none d-sm-block">Vivo</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active p-3" id="home1" role="tabpanel">
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-4">
                                                    <label for="name">Mã dự án <span style="color: red">*</span></label>
                                                    <div class="inner row">
                                                        <div class="col-md-10 col-10">
                                                            <select class="form-control" id="ma_da" name="ma_da">
                                                                <option value="0">---Vui lòng chọn---</option>
                                                                @foreach($da as $item)
                                                                    <option value="{{$item->id}}">{{$item->ma_da}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 col-4">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMaDa" style="border-radius: 0 3px 3px 0; box-shadow: none;">...
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <label for="name">Mã template <span style="color: red">*</span></label>
                                                    <div class="inner row">
                                                        <div class="col-md-10 col-10">
                                                            <select class="form-control" id="template" name="template">
                                                                <option value="0">---Vui lòng chọn---</option>
                                                                @foreach($template as $item)
                                                                    <option value="{{$item->id}}">{{$item->template}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 col-4">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTemplate" style="border-radius: 0 3px 3px 0; box-shadow: none;">...
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <label for="name">Mã Project <span style="color: red">*</span></label>
                                                    <input type="text" id="projectname" name="projectname" class="form-control" required>
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-4 input_title_app">
                                                    <label for="name">Tiêu đề ứng dụng  <span style="color: red">*</span></label>
                                                    <input type="text" id="title_app" name="title_app" class="form-control" required >
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <label for="name">Version Number <span style="color: red">*</span></label>
                                                    <input type="number" id="buildinfo_vernum" name="buildinfo_vernum" class="form-control" required >
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <label for="name">Version String<span style="color: red">*</span></label>
                                                    <input type="text" id="buildinfo_verstr" name="buildinfo_verstr" class="form-control" required >
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">

                                            </div>
                                            <div data-repeater-item="" class="row input_buildinfo">

                                                <div class="form-group col-lg-4 ">
                                                    <label for="name">App Name (APP_NAME_X)</label>
                                                    <input type="text" id="buildinfo_app_name_x" name="buildinfo_app_name_x" class="form-control" >
                                                </div>
                                                <div class="form-group col-lg-4 ">
                                                    <label for="name">Keystore Profile </label>
                                                    <input type="text" id="buildinfo_keystore" name="buildinfo_keystore" class="form-control" >
                                                </div>
                                                <div class="form-group col-lg-4 ">
                                                    <label for="name">SDK </label>
                                                    <input type="text" id="buildinfo_sdk" name="buildinfo_sdk" class="form-control" >
                                                </div>



                                            </div>

                                            <div data-repeater-item="" class="row input_buildinfo">

                                                <div class="form-group col-lg-4 ">
                                                    <label for="name">Link Policy</label>
                                                    <input type="text" id="buildinfo_link_policy_x" name="buildinfo_link_policy_x" class="form-control" >
                                                </div>
                                                <div class="form-group col-lg-4 ">
                                                    <label for="name">Link Youtube </label>
                                                    <input type="text" id="buildinfo_link_youtube_x" name="buildinfo_link_youtube_x" class="form-control" >
                                                </div>
                                                <div class="form-group col-lg-4 ">
                                                    <label for="name">Link Fanpage </label>
                                                    <input type="text" id="buildinfo_link_fanpage" name="buildinfo_link_fanpage" class="form-control" >
                                                </div>


                                            </div>
                                            <div data-repeater-item="" class="row input_buildinfo">
                                                <div class="form-group col-lg-6 ">
                                                    <label for="name">Key API APP</label>
                                                    <input type="text" id="buildinfo_api_key_x" name="buildinfo_api_key_x" class="form-control" >
                                                </div>
                                                <div class="form-group col-lg-6 ">
                                                    <label for="name">Link Website</label>
                                                    <input type="text" id="buildinfo_link_website" name="buildinfo_link_website" class="form-control" >
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row input_buildinfo">
                                            </div>

                                            <div class="progress m-b-10" style="height: 3px;">
                                                <div class="progress-bar"  role="progressbar" style="background-color: #0b0b0b;width: 100%;"></div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-3 input_package">
                                                    <label for="name">Tên Package CH-Play </label>
                                                    <input type="text" id="Chplay_package" name="Chplay_package" class="form-control">
                                                </div>
                                                <div class="form-group col-lg-9">
                                                    <label for="name">Ads CHPlay</label>
                                                    <div class="row" >
                                                        <div class="col-lg-2">
                                                            <input type="text" id="Chplay_ads_id" name="Chplay_ads_id" placeholder="ads_id" class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Chplay_ads_banner" name="Chplay_ads_banner" placeholder="ads_banner"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Chplay_ads_inter" name="Chplay_ads_inter" placeholder="ads_inter"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Chplay_ads_reward" name="Chplay_ads_reward" placeholder="ads_reward"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Chplay_ads_native" name="Chplay_ads_native" placeholder="ads_native"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Chplay_ads_open" name="Chplay_ads_open" placeholder="ads_open"  class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-3 input_package">
                                                    <label for="name">Tên Package Amazon</label>
                                                    <input type="text" id="Amazon_package" name="Amazon_package" class="form-control">
                                                </div>

                                                <div class="form-group col-lg-9">
                                                    <label for="name">Ads Amazon</label>
                                                    <div class="row" >
                                                        <div class="col-lg-2">
                                                            <input type="text" id="Amazon_ads_id" name="Amazon_ads_id" placeholder="ads_id" class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Amazon_ads_banner" name="Amazon_ads_banner" placeholder="ads_banner"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Amazon_ads_inter" name="Amazon_ads_inter" placeholder="ads_inter"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Amazon_ads_reward" name="Amazon_ads_reward" placeholder="ads_reward"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Amazon_ads_native" name="Amazon_ads_native" placeholder="ads_native"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Amazon_ads_open" name="Amazon_ads_open" placeholder="ads_open"  class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-3 input_package">
                                                    <label for="name">Tên Package SamSung </label>
                                                    <input type="text" id="Samsung_package" name="Samsung_package" class="form-control">
                                                </div>

                                                <div class="form-group col-lg-9">
                                                    <label for="name">Ads Sam Sung</label>
                                                    <div class="row" >
                                                        <div class="col-lg-2">
                                                            <input type="text" id="Samsung_ads_id" name="Samsung_ads_id" placeholder="ads_id" class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Samsung_ads_banner" name="Samsung_ads_banner" placeholder="ads_banner"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Samsung_ads_inter" name="Samsung_ads_inter" placeholder="ads_inter"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Samsung_ads_reward" name="Samsung_ads_reward" placeholder="ads_reward"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Samsung_ads_native" name="Samsung_ads_native" placeholder="ads_native"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Samsung_ads_open" name="Samsung_ads_open" placeholder="ads_open"  class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-3 input_package">
                                                    <label for="name">Tên Package Xiaomi </label>
                                                    <input type="text" id="Xiaomi_package" name="Xiaomi_package" class="form-control">
                                                </div>

                                                <div class="form-group col-lg-9">
                                                    <label for="name">Ads Xiaomi</label>
                                                    <div class="row" >
                                                        <div class="col-lg-2">
                                                            <input type="text" id="Xiaomi_ads_id" name="Xiaomi_ads_id" placeholder="ads_id" class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Xiaomi_ads_banner" name="Xiaomi_ads_banner" placeholder="ads_banner"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Xiaomi_ads_inter" name="Xiaomi_ads_inter" placeholder="ads_inter"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Xiaomi_ads_reward" name="Xiaomi_ads_reward" placeholder="ads_reward"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Xiaomi_ads_native" name="Xiaomi_ads_native" placeholder="ads_native"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Xiaomi_ads_open" name="Xiaomi_ads_open" placeholder="ads_open"  class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-3 input_package">
                                                    <label for="name">Tên Package Oppo </label>
                                                    <input type="text" id="Oppo_package" name="Oppo_package" class="form-control">
                                                </div>

                                                <div class="form-group col-lg-9">
                                                    <label for="name">Ads Oppo</label>
                                                    <div class="row" >
                                                        <div class="col-lg-2">
                                                            <input type="text" id="Oppo_ads_id" name="Oppo_ads_id" placeholder="ads_id" class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Oppo_ads_banner" name="Oppo_ads_banner" placeholder="ads_banner"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Oppo_ads_inter" name="Oppo_ads_inter" placeholder="ads_inter"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Oppo_ads_reward" name="Oppo_ads_reward" placeholder="ads_reward"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Oppo_ads_native" name="Oppo_ads_native" placeholder="ads_native"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Oppo_ads_open" name="Oppo_ads_open" placeholder="ads_open"  class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-3 input_package">
                                                    <label for="name">Tên Package Vivo </label>
                                                    <input type="text" id="Vivo_package" name="Vivo_package" class="form-control">
                                                </div>

                                                <div class="form-group col-lg-9">
                                                    <label for="name">Ads Vivo</label>
                                                    <div class="row" >
                                                        <div class="col-lg-2">
                                                            <input type="text" id="Vivo_ads_id" name="Vivo_ads_id" placeholder="ads_id" class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Vivo_ads_banner" name="Vivo_ads_banner" placeholder="ads_banner"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Vivo_ads_inter" name="Vivo_ads_inter" placeholder="ads_inter"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Vivo_ads_reward" name="Vivo_ads_reward" placeholder="ads_reward"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Vivo_ads_native" name="Vivo_ads_native" placeholder="ads_native"  class="form-control" >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input type="text" id="Vivo_ads_open" name="Vivo_ads_open" placeholder="ads_open"  class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                        <div class="tab-pane p-3" id="chplay" role="tabpanel">

                                            <div data-repeater-item="" class="row input_buildinfo">
                                                <div class="form-group col-lg-6">
                                                    <label for="name">Store Name (CH Play) </label>
                                                    <select class="form-control select2" id="Chplay_buildinfo_store_name_x" name="Chplay_buildinfo_store_name_x">
                                                        <option >---Vui lòng chọn---</option>
                                                        @foreach($store_name as $item)
                                                            <option value="{{$item->id}}">{{$item->dev_name}} : {{$item->store_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 ">
                                                    <label for="name">Link Store </label>
                                                    <input type="text" id="Chplay_buildinfo_link_store" name="Chplay_buildinfo_link_store" class="form-control" >
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Email Dev</label>
                                                    <input type="text" id="Chplay_buildinfo_email_dev_x" name="Chplay_buildinfo_email_dev_x" class="form-control" >
                                                </div>
                                                <div class="form-group col-lg-6 input_status">
                                                    <label for="name">Trạng thái Ứng dụng</label>
                                                    <div>
                                                        <select class="form-control" id="Chplay_status" name="Chplay_status">
                                                            <option value="0">Mặc định</option>
                                                            <option value="1">Publish</option>
                                                            <option value="2">Suppend</option>
                                                            <option value="3">UnPublish</option>
                                                            <option value="4">Remove</option>
                                                            <option value="5">Reject</option>
                                                            <option value="6">Check</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Link App</label>
                                                    <input type="text" id="Chplay_buildinfo_link_app" name="Chplay_buildinfo_link_app" class="form-control" >
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane p-3" id="amazon" role="tabpanel">
                                            <div data-repeater-item="" class="row input_buildinfo">
                                                <div class="form-group col-lg-6">
                                                    <label for="name">Store Name (Amazon) </label>
                                                    <select class="form-control select2" id="Amazon_buildinfo_store_name_x" name="Amazon_buildinfo_store_name_x">
                                                        <option >---Vui lòng chọn---</option>
                                                        @foreach($store_name_amazon as $item)
                                                            <option value="{{$item->id}}">{{$item->amazon_dev_name}} : {{$item->amazon_store_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 ">
                                                    <label for="name">Link Store </label>
                                                    <input type="text" id="Amazon_buildinfo_link_store" name="Amazon_buildinfo_link_store" class="form-control" >
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Email Dev</label>
                                                    <input type="text" id="Amazon_buildinfo_email_dev_x" name="Amazon_buildinfo_email_dev_x" class="form-control" >
                                                </div>
                                                <div class="form-group col-lg-6 input_status">
                                                    <label for="name">Trạng thái Ứng dụng</label>
                                                    <div>
                                                        <select class="form-control" id="Amazon_status" name="Amazon_status">
                                                            <option value="0">Mặc định</option>
                                                            <option value="1">Publish</option>
                                                            <option value="2">Suppend</option>
                                                            <option value="3">UnPublish</option>
                                                            <option value="4">Remove</option>
                                                            <option value="5">Reject</option>
                                                            <option value="6">Check</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Link App</label>
                                                    <input type="text" id="Amazon_buildinfo_link_app" name="Amazon_buildinfo_link_app" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-3" id="samsung" role="tabpanel">
                                            <div data-repeater-item="" class="row input_buildinfo">
                                                <div class="form-group col-lg-6">
                                                    <label for="name">Store Name (Samsung) </label>
                                                    <select class="form-control select2" id="Samsung_buildinfo_store_name_x" name="Samsung_buildinfo_store_name_x">
                                                        <option >---Vui lòng chọn---</option>
                                                        @foreach($store_name_samsung as $item)
                                                            <option value="{{$item->id}}">{{$item->samsung_dev_name}} : {{$item->samsung_store_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 ">
                                                    <label for="name">Link Store </label>
                                                    <input type="text" id="Samsung_buildinfo_link_store" name="Samsung_buildinfo_link_store" class="form-control" >
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Email Dev</label>
                                                    <input type="text" id="Samsung_buildinfo_email_dev_x" name="Samsung_buildinfo_email_dev_x" class="form-control" >
                                                </div>
                                                <div class="form-group col-lg-6 input_status">
                                                    <label for="name">Trạng thái Ứng dụng</label>
                                                    <div>
                                                        <select class="form-control" id="Samsung_status" name="Samsung_status">
                                                            <option value="0">Mặc định</option>
                                                            <option value="1">Publish</option>
                                                            <option value="2">Suppend</option>
                                                            <option value="3">UnPublish</option>
                                                            <option value="4">Remove</option>
                                                            <option value="5">Reject</option>
                                                            <option value="6">Check</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Link App</label>
                                                    <input type="text" id="Samsung_buildinfo_link_app" name="Samsung_buildinfo_link_app" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-3" id="xiaomi" role="tabpanel">
                                            <div data-repeater-item="" class="row input_buildinfo">
                                                <div class="form-group col-lg-6">
                                                    <label for="name">Store Name (Xiaomi) </label>
                                                    <select class="form-control select2" id="Xiaomi_buildinfo_store_name_x" name="Xiaomi_buildinfo_store_name_x">
                                                        <option >---Vui lòng chọn---</option>
                                                        @foreach($store_name_xiaomi as $item)
                                                            <option value="{{$item->id}}">{{$item->xiaomi_dev_name}} : {{$item->xiaomi_store_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 ">
                                                    <label for="name">Link Store </label>
                                                    <input type="text" id="Xiaomi_buildinfo_link_store" name="Xiaomi_buildinfo_link_store" class="form-control" >
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Email Dev</label>
                                                    <input type="text" id="Xiaomi_buildinfo_email_dev_x" name="Xiaomi_buildinfo_email_dev_x" class="form-control" >
                                                </div>
                                                <div class="form-group col-lg-6 input_status">
                                                    <label for="name">Trạng thái Ứng dụng</label>
                                                    <div>
                                                        <select class="form-control" id="Xiaomi_status" name="Xiaomi_status">
                                                            <option value="0">Mặc định</option>
                                                            <option value="1">Publish</option>
                                                            <option value="2">Suppend</option>
                                                            <option value="3">UnPublish</option>
                                                            <option value="4">Remove</option>
                                                            <option value="5">Reject</option>
                                                            <option value="6">Check</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Link App</label>
                                                    <input type="text" id="Xiaomi_buildinfo_link_app" name="Xiaomi_buildinfo_link_app" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-3" id="oppo" role="tabpanel">
                                            <div data-repeater-item="" class="row input_buildinfo">
                                                <div class="form-group col-lg-6">
                                                    <label for="name">Store Name (OPPO) </label>
                                                    <select class="form-control select2" id="Oppo_buildinfo_store_name_x" name="Oppo_buildinfo_store_name_x">
                                                        <option >---Vui lòng chọn---</option>
                                                        @foreach($store_name_oppo as $item)
                                                            <option value="{{$item->id}}">{{$item->oppo_dev_name}} : {{$item->oppo_store_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 ">
                                                    <label for="name">Link Store </label>
                                                    <input type="text" id="Oppo_buildinfo_link_store" name="Oppo_buildinfo_link_store" class="form-control" >
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Email Dev</label>
                                                    <input type="text" id="Oppo_buildinfo_email_dev_x" name="Oppo_buildinfo_email_dev_x" class="form-control" >
                                                </div>
                                                <div class="form-group col-lg-6 input_status">
                                                    <label for="name">Trạng thái Ứng dụng</label>
                                                    <div>
                                                        <select class="form-control" id="Oppo_status" name="Oppo_status">
                                                            <option value="0">Mặc định</option>
                                                            <option value="1">Publish</option>
                                                            <option value="2">Suppend</option>
                                                            <option value="3">UnPublish</option>
                                                            <option value="4">Remove</option>
                                                            <option value="5">Reject</option>
                                                            <option value="6">Check</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Link App</label>
                                                    <input type="text" id="Oppo_buildinfo_link_app" name="Oppo_buildinfo_link_app" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-3" id="vivo" role="tabpanel">
                                            <div data-repeater-item="" class="row input_buildinfo">
                                                <div class="form-group col-lg-6">
                                                    <label for="name">Store Name (Vivo) </label>
                                                    <select class="form-control select2" id="Vivo_buildinfo_store_name_x" name="Vivo_buildinfo_store_name_x">
                                                        <option >---Vui lòng chọn---</option>
                                                        @foreach($store_name_vivo as $item)
                                                            <option value="{{$item->id}}">{{$item->vivo_dev_name}} : {{$item->vivo_store_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 ">
                                                    <label for="name">Link Store </label>
                                                    <input type="text" id="Vivo_buildinfo_link_store" name="Vivo_buildinfo_link_store" class="form-control" >
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Email Dev</label>
                                                    <input type="text" id="Vivo_buildinfo_email_dev_x" name="Vivo_buildinfo_email_dev_x" class="form-control" >
                                                </div>
                                                <div class="form-group col-lg-6 input_status">
                                                    <label for="name">Trạng thái Ứng dụng</label>
                                                    <div>
                                                        <select class="form-control" id="Vivo_status" name="Vivo_status">
                                                            <option value="0">Mặc định</option>
                                                            <option value="1">Publish</option>
                                                            <option value="2">Suppend</option>
                                                            <option value="3">UnPublish</option>
                                                            <option value="4">Remove</option>
                                                            <option value="5">Reject</option>
                                                            <option value="6">Check</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-repeater-item="" class="row">
                                                <div class="form-group col-lg-6 input_buildinfo_keystore">
                                                    <label for="name">Link App</label>
                                                    <input type="text" id="Vivo_buildinfo_link_app" name="Vivo_buildinfo_link_app" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="projectQuickForm" name="projectQuickForm" class="form-horizontal">
                    <input type="hidden" name="project_id" id="quick_project_id">
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
                        <label for="name" class="col-sm-5 control-label">Trạng thái Console</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="quick_buildinfo_console" name="buildinfo_console">
                                <option value="0">Trạng thái tĩnh</option>
                                <option value="1">Build App</option>
                                <option value="2" hidden>Đang xử lý Build App</option>
                                <option value="3" hidden >Kết thúc Build App</option>
                                <option value="4">Check Data Project</option>
                                <option value="5"hidden>Đang xử lý check dữ liệu của Project</option>
                                <option value="6"hidden>Kết thúc Check</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveQBtn" value="create">Save changes
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addMaDa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm mới Mã dự án</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form id="AddDaForm" name="AddDaForm" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-5 control-label">Tên dự án</label>
                        <div class="col-sm-12">
                            <input type="hidden" name="da_id" id="add_da_id">
                            <input type="text" class="form-control" id="add_ma_da" name="ma_da" placeholder="Mã dự án" required>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="addTemplate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm mới Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form id="AddTempForm" name="AddTempForm" class="form-horizontal">
                    <input type="hidden" name="template_id" id="template_id">
                    <div data-repeater-list="group-a">
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6 ">
                                <label for="name">Tên Template <span style="color: red">*</span></label>
                                <input type="text" id="add_template" name="template" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6 ">
                                <label for="name">Ver Build</label>
                                <input type="text" id="ver_build" name="ver_build" class="form-control">
                            </div>
                        </div>

                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6 input_package">
                                <label for="name">script_copy </label>
                                <textarea id="script_copy" name="script_copy" class="form-control" rows="4" ></textarea>
                            </div>
                            <div class="form-group col-lg-6 input_title_app">
                                <label for="name">script_img</label>
                                <textarea id="script_img" name="script_img" class="form-control" rows="4" ></textarea>
                            </div>
                        </div>

                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6 input_package">
                                <label for="name">script_svg2xml </label>
                                <textarea id="script_svg2xml" name="script_svg2xml" class="form-control" rows="4" ></textarea>
                            </div>
                            <div class="form-group col-lg-6 input_title_app">
                                <label for="name">Ghi chú</label>
                                <textarea id="note" name="note" class="form-control" rows="4" ></textarea>
                            </div>
                        </div>
                        <div data-repeater-item="" class="row">
                            <div class="form-group col-lg-6 input_ma_da">
                                <label for="name">Link của ứng dụng trên CHPlay</label>
                                <input type="text" id="link_chplay" name="link_chplay" class="form-control" >
                            </div>
                            <div class="form-group col-lg-6 input_projectname">
                                <label for="name">category</label>
                                <input type="text" id="category" name="category" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="showPolicy" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeadingPolicy"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="policy-1">
                    <label for="name">Policy 1 <button type="button" onclick="copy1()" class="btn btn-link waves-effect copyboard"><i class="mdi mdi-content-copy"></i></button> </label>
                    <textarea  type="text" id="policy1"  name="policy1" rows="8" class="form-control" > </textarea>
                </div>
                <div class="policy-2">
                    <label  for="name">Policy 2 <button type="button" onclick="copy2()" class="btn btn-link waves-effect copyboard"><i class="mdi mdi-content-copy"></i></button></label>
                    <textarea  type="text" id="policy2"  name="policy2" rows="8" class="form-control" > </textarea>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>











