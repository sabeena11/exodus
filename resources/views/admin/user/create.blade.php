@extends('layouts.app')

@push('head-script')
    <style>
        .field-icon {
            float: right;
            cursor: pointer;
            margin-left: -25px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
            margin-right: 7px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
@endpush

@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('app.createNew')</h4>

                    <form id="editSettings" class="ajax-form" autocomplete="off">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="required">@lang('app.user.name')</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">@lang('app.user.email')</label>
                                    <input type="email" class="form-control" id="email" name="email" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address" class="required">@lang('app.user.address')</label>
                                    <input type="text" class="form-control" id="address" name="address">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="sex" class="required">@lang('app.user.sex')</label>
                                    <select name="sex" id="sex" class="form-control">
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                        <option value="3">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="dob" class="required">@lang('app.user.dob')</label>
                                    <input type="date" class="form-control" id="dob" name="dob">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           
                             <div class="col-md-2">
                                <label for="password" class="required">@lang('app.user.password')</label>
                                <div class="form-group">
                                    <div>
                                        <input type="password" class="form-control" id="password" name="password" autocomplete="off">
                                        <span class="fa fa-fw fa-eye-slash field-icon " onclick="showPassword()"></span>
                                     </div>
                                     <div>
                                        <span class="help-block"> @lang('app.messages.passwordlength')</span>
                                     </div>
                                </div>
                            </div>
                            <div class="col-md-2"> 
        <div class="form-group">
            <label class="required">@lang('app.user.mobile')</label>
            <input type="text" class="form-control" name="mobile">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="company_phone">@lang('app.user.branch')</label>
            <select class="form-control select" name="branch_id" id="branch_id">
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    </div>
                        
   
<div class="col-md-3"> 
        <div class="form-group">
            <label for="exampleInputPassword1">@lang('app.user.image')</label>
            <div class="card">
                <div class="card-body">
                    <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg"
                        class="dropify" data-default-file="{{ asset('avatar.png') }}"/>
                </div>
            </div>
        </div>
    </div>

                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                                    @lang('app.save')
                                </button>
                                <button type="reset"
                                    class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                            </div>
                        </div>
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
                url: '{{ route('admin.user.store') }}',
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
