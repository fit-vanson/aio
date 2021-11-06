@extends('layouts.master')

@section('title') @lang('translation.Form_Advanced') @endsection

@section('css')
    <!-- Plugin css -->
    <link href="assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Select2</h4>
                    <form>
                        <div class="form-group">
                            <label class="control-label">Single Select</label>
                            <select class="select2 form-select js_brand" data-type="brand">
                                <option>--Chọn Hãng--</option>
                                @foreach($brand as $item)
                                    <option value="{{$item->brand}}">{{$item->brand}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Single Select</label>
                            <select class="select2 form-select js_model" id="model" name="model">
                                <option>--Chọn Model--</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>


        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="row" id="list_imei">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List Imei</h4>
                    <div class="card-body d-flex justify-content-center">
                        <ul class="list-group" id="imei_gen">
                        </ul>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <!-- end page title -->
@endsection

@section('script')
    <!-- Summernote js -->
    <script src="assets/libs/select2/select2.min.js"></script>

    <!-- demo js -->
{{--    <script src="assets/js/pages/form-advanced.init.js"></script>--}}

    <script>
        $('#list_imei').hide();
        $(".select2").select2();
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

