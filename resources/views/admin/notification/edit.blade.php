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
                                <label class="required">@lang('app.notification.title')</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    value="{{ $notification->title }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="required">@lang('app.notification.details')</label>
                                <textarea id="details" name="details" rows="4" cols="50" class="form-control">{{ $notification->details }} </textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="required">User</label>
                                <select name="user_id" id="user_id" class="form-control select">
                                    <option selected disabled>--------</option>
                                    @foreach ($users as $data)
                                        <option value="{{ $data->id }}"
                                            @if ($notification->user_id == $data->id) selected @endif>{{ $data->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('app.notification.image')</label>
                                <div class="card">
                                    <div class="card-body">

                                        <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg"
                                            class="dropify"
                                            data-default-file="{{ asset('user-uploads/notification/' . $notification->image) }}" />
                                    </div>
                                </div>

                            </div>

                        </div>
                        <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                            @lang('app.save')
                        </button>
                        <button type="reset" class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
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
                default: '@lang('app.dragDrop')',
                replace: '@lang('app.dragDropReplace')',
                remove: '@lang('app.remove')',
                error: '@lang('app.largeFile')'
            }
        });

        $('#save-form').click(function() {
            $.easyAjax({
                url: '{{ route('admin.notifications.update', $notification->id) }}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
        $(function() {
            // $(this).addClass('fa-eye');
            $('.field-icon').click(function() {
                if ($(this).hasClass('fa-eye-slash')) {
                    $(this).removeClass('fa-eye-slash');
                    $(this).addClass('fa-eye');
                    $('#password').attr('type', 'text');
                } else {
                    $(this).removeClass('fa-eye');
                    $(this).addClass('fa-eye-slash');
                    $('#password').attr('type', 'password');
                }
            });
        });

        $(document).ready(function() {
            $('.select').select2();
        });
    </script>
@endpush
