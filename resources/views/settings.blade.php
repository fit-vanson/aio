@extends('layouts.master')

@section('title') @lang('translation.Form_Validation') @endsection

@section('content')

    <!-- start page title -->
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Settings</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <form id="settingsForm" name="settingsForm">
                        <div class="form-group">
                            <label>Time Cron </label>
                            <p class="card-title-desc" style="color:#afa5a5;">Minute</p>
                            <div>
                                <input type="number" class="form-control" id="time_cron" name="time_cron" value="{{$data['time_cron']}}"/>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                                </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection

@section('script')
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#settingsForm').on('submit',function (event){
                event.preventDefault();
                var formData = new FormData($("#settingsForm")[0]);

                $.ajax({
                    data: formData,
                    url: "{{ route('settings.update') }}",
                    type: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if(data.errors){
                            for( var count=0 ; count <data.errors.length; count++){
                                $("#settingsForm").notify(
                                    data.errors[count],"error",
                                    { position:"right" }
                                );
                            }
                        }
                        if(data.success){
                            $.notify(data.success, "success");
                            $('#time_cron').val(data.data.time_cron);

                        }
                    },
                });

            });


        });
    </script>

@endsection
