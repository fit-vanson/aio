@extends('layouts.master')

@section('css')
/*<!--Chartist Chart CSS -->*/
<link rel="stylesheet" href="plugins/chartist/css/chartist.min.css">
@endsection

@section('breadcrumb')
<div class="col-sm-6">
     <h4 class="page-title">Trang chủ</h4>
     <ol class="breadcrumb">
         <li class="breadcrumb-item active">Chào mừng đến với trang quản trị</li>
     </ol>
</div>
@endsection

@section('content')

{{--                   <div class="row">--}}
{{--                            <div class="col-xl-4 col-md-4">--}}
{{--                                <div class="card mini-stat bg-primary text-white">--}}
{{--                                    <div class="card-body">--}}
{{--                                        <div class="mb-4">--}}
{{--                                            <div class="float-left mini-stat-img mr-4">--}}
{{--                                                <img src="assets/images/services-icon/01.png" alt="" >--}}
{{--                                            </div>--}}
{{--                                            <h5 class="font-16 text-uppercase mt-0 text-white-50">Số hình ảnh</h5>--}}
{{--                                            <h4 class="font-500">{{$list_image}}</h4>--}}
{{--                                        </div>--}}
{{--                                        <div class="pt-2">--}}
{{--                                            <div class="float-right">--}}
{{--                                                <a href="{{route('upload_index')}}" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>--}}
{{--                                            </div>--}}
{{--                                            <p class="text-white-50 mb-0">Since last month</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-xl-4 col-md-4">--}}
{{--                                <div class="card mini-stat bg-primary text-white">--}}
{{--                                    <div class="card-body">--}}
{{--                                        <div class="mb-4">--}}
{{--                                            <div class="float-left mini-stat-img mr-4">--}}
{{--                                                <img src="assets/images/services-icon/02.png" alt="" >--}}
{{--                                            </div>--}}
{{--                                            <h5 class="font-16 text-uppercase mt-0 text-white-50">Số người truy cập</h5>--}}
{{--                                            <h4 class="font-500">{{$list_user_view}} </h4>--}}
{{--                                        </div>--}}
{{--                                        <div class="pt-2">--}}
{{--                                            <div class="float-right">--}}
{{--                                                <a href="{{route('list_ip')}}" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>--}}
{{--                                            </div>--}}

{{--                                            <p class="text-white-50 mb-0">Since last month</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-xl-4 col-md-4">--}}
{{--                                <div class="card mini-stat bg-primary text-white">--}}
{{--                                    <div class="card-body">--}}
{{--                                        <div class="mb-4">--}}
{{--                                            <div class="float-left mini-stat-img mr-4">--}}
{{--                                                <img src="assets/images/services-icon/02.png" alt="" >--}}
{{--                                            </div>--}}
{{--                                            <h5 class="font-16 text-uppercase mt-0 text-white-50">Số ảnh truy cập</h5>--}}
{{--                                            <h4 class="font-500">{{$list_image_view}} </h4>--}}
{{--                                        </div>--}}
{{--                                        <div class="pt-2">--}}
{{--                                            <div class="float-right">--}}
{{--                                                <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>--}}
{{--                                            </div>--}}

{{--                                            <p class="text-white-50 mb-0">Since last month</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <!-- end row -->
@endsection

@section('script')
<!--Chartist Chart-->
<script src="plugins/chartist/js/chartist.min.js"></script>
<script src="plugins/chartist/js/chartist-plugin-tooltip.min.js"></script>
<!-- peity JS -->
<script src="plugins/peity-chart/jquery.peity.min.js"></script>
<script src="assets/pages/dashboard.js"></script>
@endsection
