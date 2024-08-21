@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('app.edit')</h4>

                    <form id="editSettings" class="ajax-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="rewardValue">@lang('app.appConfigs.rewardValue')</label>
                            <input type="text" class="form-control" id="rewardValue" name="rewardValue" value="{{ $appconfigData->reward_value }}">
                        </div>
                        <div class="form-group">
                            <label for="smsToken">@lang('app.appConfigs.smsToken')</label>
                            <input type="text" class="form-control" id="smsToken" name="smsToken" value="{{ $appconfigData->sms_token }}">
                        </div>
                        <div class="form-group">
                            <label for="enableSms">@lang('app.appConfigs.enableSms')</label>
                            <div>
                                <input type="radio" id="enableSms" name="enableSms" value="1" @if ($appconfigData->enable_sms==1)checked @endif><label for="">Enable</label>
                                <input type="radio" id="enableSms" name="enableSms" value=null @if ($appconfigData->enable_sms==0)checked @endif><label for="">Disable</label>
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                            <label for="enableNotification">@lang('app.appConfigs.enableNotification')</label>
                            <div>
                                <input type="radio" id="enableNotification" name="enableNotification" value="1" @if ($appconfigData->enable_notifications==1)checked @endif><label for="">Enable</label>
                                <input type="radio" id="enableNotification" name="enableNotification" value=null @if ($appconfigData->enable_notifications==0)checked @endif><label for="">Disable</label>
                            </div>
                            
                        </div>

                        <button type="button" id="save-form"
                                class="btn btn-success waves-effect waves-light m-r-10">
                            @lang('app.save')
                        </button>
                        <button type="reset"
                                class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.app-configs.update', $appconfigData->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>

@endpush