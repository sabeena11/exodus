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
                        <div class="form-group">
                            <label for="point">@lang('app.coupon.point')</label>
                            <input type="number" class="form-control w-25" id="point" name="point">
                        </div>
                        <div class="form-group">
                            <label for="image">@lang('app.coupon.image')</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="title">@lang('app.coupon.title')</label>
                            <input type="email" class="form-control" id="title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="desc">@lang('app.gifts.desc')</label>
                            <input type="text" class="form-control" id="desc" name="desc" style="height:150px;">
                        </div>
                        <div class="form-group">
                            <label for="startdate">@lang('app.coupon.startdate')</label>
                            <input type="date" class="form-control w-25" id="startdate" name="startdate"><br>
                            <input type="time" class="form-control w-25" id="startdate" name="startdate">
                        </div>
                        <div class="form-group">
                            <label for="enddate">@lang('app.coupon.enddate')</label>
                            <input type="date" class="form-control w-25" id="enddate" name="enddate"><br>
                            <input type="time" class="form-control w-25" id="enddate" name="enddate">
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
                url: '{{route('admin.user.store')}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
        $(function(){
            // $(this).addClass('fa-eye');
        $('.field-icon').click(function(){
            if($(this).hasClass('fa-eye-slash')){
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
                $('#password').attr('type','text');
            }else{
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');  
                $('#password').attr('type','password');
                }
            });
        });
    </script>

@endpush