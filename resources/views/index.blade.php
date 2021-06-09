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
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if (session("error"))
        <div class="alert alert-danger">
            {{ session("error") }}
        </div>
    @endif
    <?php
    $secretCode = auth()->user()->secret_code;
    if(!$secretCode){
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif

                        <form role="form" method="post" action="{{ route('enable_2fa_setting') }}">
                            {{ csrf_field() }}
                            <h2>Scan barcode</h2>
                            <p class="text-muted">
                                Scan the image above with the two-factor authentication app on your phone.
                            </p>
                            <p class="text-center">
                                <img src="{{ $qrCodeUrl }}" />
                            </p>
                            <h5>Enter the six-digit code from the application</h5>
                            <p class="text-muted">
                                After scanning the barcode image, the app will display a six-digit code that you can enter below.
                            </p>
                            <div class="form-group">
                                <input type="text" name="code" class="form-control" placeholder="123456" autocomplete="off" maxlength="6">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success">Enable</button>
                                <a href="" class="btn btn-secondary float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
@endsection

@section('script')
<!--Chartist Chart-->
<script src="plugins/chartist/js/chartist.min.js"></script>
<script src="plugins/chartist/js/chartist-plugin-tooltip.min.js"></script>
<!-- peity JS -->
<script src="plugins/peity-chart/jquery.peity.min.js"></script>
<script src="assets/pages/dashboard.js"></script>
@endsection
