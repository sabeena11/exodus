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

                    <form id="editSettings" class="ajax-form" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">@lang('app.user.name')</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $userData->name }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">@lang('app.user.email')</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $userData->email }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address" class="required">@lang('app.user.address')</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ $userData->address }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="sex" class="required">@lang('app.user.sex')</label>
                                    <select name="sex" id="sex" class="form-control">
                                        <option @if ($userData->sex == 1) selected @endif>Male</option>
                                        <option @if ($userData->sex == 2) selected @endif>Female</option>
                                        <option @if ($userData->sex == 3) selected @endif>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="dob" class="required">@lang('app.user.dob')</label>
                                    
                                    <input type="date" class="form-control" id="dob" name="dob"
                                        value="{{ $userData->dob }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                             
                                    <label for="password">@lang('app.user.password')</label>
                                       <div class="form-group" style="display: flex;">
                                    
                                    <div style="flex: 1;" >
                                    <input type="password" class="form-control" id="password" name="password">
                                         </div>&nbsp;&nbsp;
                                     <div style="flex: 2;">
                                        
                                    <span class="help-block"> @lang('app.messages.passwordNote')</span>
                                
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="checkbox" class="form-control" id="is_staff" name="is_staff"
                                        @if ($userData->is_staff == 1) checked @endif>
                                    <label for="is_staff" class="required">@lang('app.user.is_staff')</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="checkbox" class="form-control" id="is_verified" name="is_verified"
                                        @if ($userData->is_verified == 1) checked @endif>
                                    <label for="is_verified" class="required">@lang('app.user.is_verified')</label>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>@lang('app.user.mobile')</label>
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="mobile"
                                                        value="{{ $userData->mobile }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-11">
                                            @if ($userData->is_verified)
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

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="company_phone">@lang('app.user.roleName')</label>
                                    <select class="form-control select" name="role_id" id="role_id">
                                        @foreach ($roles as $role)
                                            <option @if ($role->id == $userData->role->role_id) selected @endif
                                                value="{{ $role->id }}">{{ $role->display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">@lang('app.user.image')</label>
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="file" id="input-file-now" name="image"
                                                accept=".png,.jpg,.jpeg" class="dropify"
                                                data-default-file="{{ $userData->profile_image_url }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="company_phone">@lang('app.user.branch')</label>
                                <select class="form-control select" name="branch_id" id="branch_id">
                                    @foreach ($branches as $branch) 
                                        <option @if($branch->id == $userData->branch_id) selected @endif value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                
                                
                            </div>
                            
                        </div>

                        <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
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
                default: '@lang('app.dragDrop')',
                replace: '@lang('app.dragDropReplace')',
                remove: '@lang('app.remove')',
                error: '@lang('app.largeFile')'
            }
        });

        $('#save-form').click(function() {
            $.easyAjax({
                url: '{{ route('admin.user.update', $userData->id) }}',
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
