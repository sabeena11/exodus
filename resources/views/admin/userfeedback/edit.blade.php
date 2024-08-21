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
                            <label for="details">@lang('app.feedBacks.details')</label>
                            <input type="text" class="form-control" id="details" name="details" value="{{ $feedbackData->details }}">
                        </div>

                        <div class="form-group">
                            <label for="user_id">@lang('app.feedBacks.user_id')</label>
                            <select class="form-control select" name="user_id" id="user_id">
                                @foreach ($users as $data)
                                    <option value="{{$data->id}}" @if ($feedbackData->user_id == $data->id)selected @endif>{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- <div class="form-group">
                            <label for="status">@lang('app.feedBacks.status')</label>
                            <input type="text" class="form-control" id="status" name="status" value="{{ $feedbackData->status }}">
                        </div> -->

                        <div class="form-group">
                            <label for="status">@lang('app.feedBacks.status')</label>
                            <select class="form-control select" name="status" id="status">
                                <option value="0" @if ($feedbackData->status == 0) selected @endif >New</option>
                                <option value="1" @if ($feedbackData->status == 1) selected @endif >Seen</option>
                                <option value="2" @if ($feedbackData->status == 2) selected @endif >Processing</option>
                                <option value="3" @if ($feedbackData->status == 3) selected @endif >Closed</option>
                            </select>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                url: '{{route('admin.feedbacks.update', $feedbackData->id)}}',
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