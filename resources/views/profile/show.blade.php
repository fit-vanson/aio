@extends('layouts.master')

@section('title') @lang('translation.General') @endsection

@section('content')

    <!-- start page title -->
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">General</h4>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thông tin cá nhân - <button type="button" class="btn btn-secondary waves-effect" id="profile_name">{{$profile->profile_name}}</button></h4>
                    <div class="button-items">
                        <button type="button" class="btn btn-secondary waves-effect" id="profile_ho_va_ten">{{$profile->profile_ho_va_ten}}</button>
                        <button type="button" class="btn btn-secondary waves-effect" id="profile_ngay_sinh">{{$profile->profile_ngay_sinh}}</button>
                        <button type="button" class="btn btn-secondary waves-effect" id="profile_sex">{{$profile->profile_sex}}</button>
                        <button type="button" class="btn btn-secondary waves-effect" id="profile_cccd">{{$profile->profile_cccd}}</button>
                        <button type="button" class="btn btn-secondary waves-effect" id="profile_ngay_cap">{{$profile->profile_ngay_cap}}</button>
                        <button type="button" class="btn btn-secondary waves-effect" id="profile_add">{{$profile->profile_add}}</button>
                    </div>
                    <br>
                    <h5 class="card-title-desc">Thông tin công ty</h5>

                    @if($profile->company)
                        @foreach($profile->company as $company)
                            <br>
                            <div class="button-items">
                                <button type="button" class="btn btn-light waves-effect" id="mst">{{$company->mst}}</button>
                                <button type="button" class="btn btn-light waves-effect" id="name_en">{{$company->name_en}}</button>
                                <button type="button" class="btn btn-light waves-effect" id="name_vi">{{$company->name_vi}}</button>
                                <button type="button" class="btn btn-light waves-effect" id="ngay_thanh_lap">{{$company->ngay_thanh_lap}}</button>
                                <button type="button" class="btn btn-light waves-effect" id="dia_chi">{{$company->dia_chi}}</button>
                            </div>
                            <br>
                        @endforeach
                    @endif


                </div>
            </div>

        </div>

    </div>
    <!-- end row -->


@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('button').on('click', function() {
                var copyText = this.innerText;
                var textarea = document.createElement('textarea');
                textarea.id = 'temp_element';
                textarea.style.height = 0;
                document.body.appendChild(textarea);
                textarea.value = copyText;
                var selector = document.querySelector('#temp_element')
                selector.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
            });
        });
        // }
    </script>
@endsection


