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
                                    <label for="title">@lang('app.menus.title')</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $menuData->title }}">
                                </div>
                            </div>

                            

                        <div class="col-md-4">
                            <div class="form-group">
                                    <label for="link">@lang('app.menus.link')</label>
                                    <input type="text" class="form-control" id="link" name="link" value="{{ $menuData->link }}">
                                </div>
                            </div>

                         

                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="position">@lang('app.menus.position')</label>
                                <textarea  class="form-control" name="position" rows="4" required>{{ $menuData->position }}</textarea>
                            </div>
                        </div>
                       
                <div class="col-md-4"> 
                        <div class="form-group">
                            <label class="required">@lang('app.menus.section')</label>
                    <select name="section"id="section" class="form-control">
                              <option value="">Select Section</option>
                                <option value="Navbar" {{ $menuData->section == 'Navbar' ? 'selected' : '' }}>Navbar</option>
                                    <option value="Company" {{ $menuData->section == 'Company' ? 'selected' : '' }}>Company</option>
                                    <option value="Useful Links" {{ $menuData->section == 'Useful Links' ? 'selected' : '' }}>Useful Links</option>
                               
                            </select>
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
                url: '{{route('admin.menu.update', $menuData->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>

@endpush