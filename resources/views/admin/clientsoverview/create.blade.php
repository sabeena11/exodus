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
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@lang('app.createNew')</h4>

                <form id="editSettings" class="ajax-form">
                    @csrf
                        
                    <div class="col-md-4"> 
                        <div class="form-group">
                            <label class="required">@lang('app.clientsoverview.desc')</label>
                            <input type="text" id="desc" name="desc" class="form-control">
                        </div>
                    </div>  
                    <div class="col-md-4"> 
                        <div class="form-group">
                            <label class="required">@lang('app.clientsoverview.name')</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </div>  
                    <div class="col-md-4"> 
                        <div class="form-group">
                            <label class="required">@lang('app.clientsoverview.designation')</label>
                            <input type="text" id="designation" name="designation" class="form-control">
                        </div>
                    </div>  
                    <div class="col-md-4"> 
                        <div class="form-group">
                            <label>rating star</label>
                            <select name="rating_star"id="rating_star" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputPassword1">@lang('app.clientsoverview.image')</label>
                            <div class="card">
                                <div class="card-body">
                                    
                                    <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg"
                                        class="dropify" data-default-file="{{ asset('avatar.png') }}" />
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
                url: '{{ route('admin.clientsoverview.store') }}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });

        $(function() {
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