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
                            <label for="name">@lang('app.user.name')</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $userData->name }}">
                        </div>
                        <div class="form-group">
                            <label for="email">@lang('app.user.email')</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $userData->email }}">
                        </div>
                        <div class="form-group">
                            <label for="password">@lang('app.user.password')</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <span class="help-block"> @lang('app.messages.passwordNote')</span>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.user.mobile')</label>
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="mobile" value="{{ $userData->mobile }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 text-center">
                                    @if ($userData->mobile_verified)
                                        <span class="text-success">
                                            @lang('app.user.verified')
                                        </span>
                                    @else
                                        <span class="text-danger">
                                            @lang('app.user.notVerified')
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">@lang('app.user.image')</label>
                            <div class="card">
                                <div class="card-body">
                                    <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify"
                                           data-default-file="{{ $userData->profile_image_url  }}"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company_phone">@lang('app.user.roleName')</label>
                            <select class="form-control" name="role_id" id="role_id">
                                @foreach($roles as $role)
                                    <option
                                            @if($role->id == $userData->role->role_id) selected @endif
                                            value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
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
                url: '{{route('admin.user.update', $userData->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>

@endpush