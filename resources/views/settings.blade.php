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
                            <p class="card-title-desc"style="color:#afa5a5;">
                                <span class="convertedHour" id="convertedHour">{{round($data['time_cron']/60,0)}}</span> Hours
                                <span class="convertedMin" id="convertedMin">{{$data['time_cron']%60}}</span> Minutes
                            </p>
                            <div>
                                <input type="number" class="form-control" id="time_cron" name="time_cron" value="{{$data['time_cron']}}"/>
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
            const time = document.getElementById('time_cron');
            const convertedHour = document.getElementById('convertedHour');
            const convertedMin = document.getElementById('convertedMin');
            time.addEventListener('change', updateValue);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            function updateValue(e) {
                convertedHour.textContent = Math.floor(e.target.value / 60);
                convertedMin.textContent = e.target.value % 60;
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
            }


        });
    </script>

@endsection
