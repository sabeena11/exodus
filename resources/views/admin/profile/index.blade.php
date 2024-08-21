@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="editSettings" class="ajax-form">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name" class="required">@lang('app.myProfile.name')</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ ucwords($user->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="email" class="required">@lang('app.myProfile.email')</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="password">@lang('app.myProfile.password')</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="@lang('passwords.passwordLength')">
                            <span class="help-block"> @lang('app.messages.passwordNote')</span>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="required">@lang('app.myProfile.mobile')</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" 
                                    value="{{ $user->mobile }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">@lang('app.myProfile.image')</label>
                            <div class="card">
                                <div class="card-body">
                                    <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify"
                                           data-default-file="{{ $user->profile_image_url  }}"
                                    />
                                </div>
                            <span class="help-block"> @lang('app.messages.imageNote')</span>

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
                url: '{{route('admin.profile.update', $user->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })

        });
    </script>
@endpush