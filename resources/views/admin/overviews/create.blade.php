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
                                <label for="desc">@lang('app.overviews.desc')</label>
                                <textarea  class="form-control" id="desc" name="desc" rows="4" required></textarea>
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
                url: '{{route('admin.overviews.store')}}',
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