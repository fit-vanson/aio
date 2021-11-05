@extends('layouts.master')

@section('title', 'Form Layouts')
@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{asset('vendors/css/extensions/toastr.min.css')}}">
    <link rel="stylesheet" href="{{ asset(('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{asset('css/base/plugins/extensions/ext-component-toastr.css')}}">

@endsection
@section('content')

    <!-- Basic multiple Column Form section start -->
{{--    <section id="multiple-column-form">--}}
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h4 class="card-title">Multiple Column</h4>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form class="form" id="insertForm" enctype="multipart/form-data" >--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-6 col-12">--}}
{{--                                    <div class="mb-1">--}}
{{--                                        <label class="form-label" for="first-name-column">ID</label>--}}
{{--                                        <input--}}
{{--                                            type="text"--}}
{{--                                            id="imei"--}}
{{--                                            class="form-control"--}}
{{--                                            placeholder="Model"--}}
{{--                                            name="imei"--}}
{{--                                        />--}}

{{--                                    </div>--}}
{{--                                    <div class="mb-1">--}}
{{--                                        <label class="form-label" for="first-name-column">Brand</label>--}}
{{--                                        <input--}}
{{--                                            type="text"--}}
{{--                                            id="brand"--}}
{{--                                            class="form-control"--}}
{{--                                            placeholder="Brand"--}}
{{--                                            name="brand"--}}
{{--                                        />--}}

{{--                                    </div>--}}
{{--                                    <div class="mb-1">--}}
{{--                                        <label class="form-label" for="first-name-column">Model</label>--}}
{{--                                        <input--}}
{{--                                            type="text"--}}
{{--                                            id="model"--}}
{{--                                            class="form-control"--}}
{{--                                            placeholder="Model"--}}
{{--                                            name="model"--}}
{{--                                        />--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-12">--}}
{{--                                    <button type="submit" class="btn btn-primary me-1">Submit</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

    <section class="basic-select2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">IMEI Generator</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" id="insertForm" enctype="multipart/form-data" >
                            <div class="row">
                                <!-- Basic -->
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="select2-basic">Brand</label>
                                    <select class="select2 form-select js_brand" data-type="brand">
                                        <option>--Chọn Hãng--</option>
                                        @foreach($brand as $item)
                                            <option value="{{$item->brand}}">{{$item->brand}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="select2-basic">Model</label>
                                    <select class="select2 form-select js_model" id="model" name="model">
                                            <option>--Chọn Model--</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section id="list_imei">
        <div class="row match-height d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List Imei</h4>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <ul class="list-group" id="imei_gen">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Basic Floating Label Form section end -->
@endsection
@section('vendor-script')
    <script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="{{ asset(('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(('js/scripts/forms/form-select2.js')) }}"></script>
    <script>
        $('#list_imei').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.js_brand').change(function (event){
            event.preventDefault();
            let route = '{{route('imei.getBrand')}}';
            let $this = $(this);
            let type = $this.attr('data-type');
            let brand = $this.val();
            $('#list_imei').hide();
            $.ajax({
               method : "GET",
               url:route,
               data:{
                   type: type,
                   brand:brand
               }
            })
            .done(function (msg){
                if(msg.data){
                    let html = '';
                    let element = '';
                    if(type = 'brand'){
                        html = '<option>--Chọn Model--</option>';
                        element = '#model';
                    }
                    $.each(msg.data,function (index,value){
                        html += "<option value='"+value.imei_code+"'>"+value.model+"</option>"
                    })
                    $(element).html('').append(html);
                }
            })
        });

        $('.js_model').change(function (event){
            event.preventDefault();
            let route = '{{route('imei.gen_imei')}}';
            let $this = $(this);
            $('#list_imei').show();

            let model = $this.val();
            $.ajax({
                method : "GET",
                url:route,
                data:{
                    model:model
                }
            })
                .done(function (data){
                    if(data.data){
                        let html = '';
                        $.each(data.data,function (index,value){

                            html += "<li class='list-group-item'>"+value+"</li>"
                            // html += "<input type='text' class='form-control' id='copy-to-clipboard-input' value="+value+" />"
                        })
                        $('#imei_gen').html('').append(html);
                    }
                    if(data.error){
                        let html = "<div class='alert alert-danger' role='alert'><div class='alert-body'>"+data.error + "</div></div>";
                        $('#imei_gen').html('').append(html);
                    }
                })
        });

    </script>

@endsection

