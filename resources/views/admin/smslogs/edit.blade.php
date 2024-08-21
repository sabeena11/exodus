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

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" class="form-check-input" id="isactive" name="success" value="1"
                                    @if(old('success', $smslogData->success) == 1) checked @endif>
                                <label class="form-check-label" for="isactive">@lang('app.smslogs.success')</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user">@lang('app.smslogs.user')</label>
                                <select class="form-control select" name="user_id" id="user">
                                @foreach($users as $data)
                                        <option value="{{ $data->id }}" {{ $data->id == $selectedUserId ? 'selected' : '' }}>{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="message">@lang('app.smslogs.message')</label>
                                <input type="text" class="form-control" id="message" name="message" value="{{ $smslogData->message }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="response">@lang('app.smslogs.response')</label>
                                <input type="text" class="form-control" id="response" name="response" value="{{ $smslogData->response }}">
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
    <script src="{{ asset('assets/plugins/select2/select2.js') }}"></script>
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
                url: '{{route('admin.smslogs.update', $smslogData->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });

        $(document).ready(function() {
            $('.select').select2();
        });
    </script>

@endpush