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
                <h4 class="card-title">@lang('app.edit')</h4>

                <form id="editSettings" class="ajax-form">
                        @csrf
                        @method('PUT')
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="required">@lang('app.category.name')</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{$category->name}}">
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>@lang('app.category.image')</label>
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" value="{{$category->image}}"
                                            class="dropify" data-default-file="{{  asset('user-uploads/catagories/'.$category->image) }}" / >
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
                url: '{{route('admin.categories.update', $category->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>
@endpush