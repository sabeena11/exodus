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
                                    <label for="title">@lang('app.slidercards.title')</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $slidercardData->title }}">
                                </div>
                            </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="desc">@lang('app.features.icon')</label>
                                 <input type="text" class="form-control" id="icon" name="icon" value="{{ $slidercardData->icon }}">
                            <small class="form-text text-muted">Enter the name of the Material Icon (e.g., "home", "star").</small>
                           
                            </div>
                        </div>
                         

                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="desc">@lang('app.slidercards.desc')</label>
                                <textarea  class="form-control" name="desc" rows="4" required>{{ $slidercardData->desc }}</textarea>
                            </div>
                        </div>
                       
               

                        <button type="button" id="save-form"
                                class="btn btn-success waves-effect waves-light m-r-10">
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
                url: '{{route('admin.slidercards.update', $slidercardData->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>

@endpush