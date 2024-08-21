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
                                        <label for="exampleInputPassword1">@lang('app.banners.image')</label>
                                        <div class="card">
                                            <div class="card-body">
                                                <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify" data-default-file="{{ old('image') ? asset('user-uploads/banners/'.old('image')) : asset('user-uploads/banners/'.$bannerData->image) }}"  />
                                            </div>
                                        </div>
                                    </div>
                        </div>
                            

                        <div class="col-md-4">
                            <div class="form-group">
                                    <label for="title">@lang('app.banners.title')</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $bannerData->title }}">
                                </div>
                            </div>

                            <div class="col-md-4">                            
                                <div class="form-group">
                                        <label for="url">@lang('app.banners.url')</label>
                                        <input type="email" class="form-control" id="url" name="url" value="{{ $bannerData->url }}">
                                    </div>
                            </div>

                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="desc">@lang('app.banners.desc')</label>
                                <textarea  class="form-control" name="desc" rows="4" required>{{ $bannerData->desc }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                                <input type="checkbox" class="form-check-input" id="isactive" name="is_active"  value="1"
             @if(old('is_active', $bannerData->is_active) == 1) checked @endif>

                                <label class="form-check-label" for="isactive">@lang('app.banners.isactive')</label>
                        </div>

                        <div class="form-group">
                            <label for="views">@lang('app.banners.views')</label>
                            <input type="number" class="form-control w-25" id="views" name="views" value="{{ $bannerData->views }}">
                        </div>
                        <div class="form-group">
                            <label for="priority">@lang('app.banners.priority')</label>
                            <input type="number" class="form-control w-25" id="priority" name="priority" value="{{ $bannerData->priority }}">
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
                url: '{{route('admin.banners.update', $bannerData->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>

@endpush