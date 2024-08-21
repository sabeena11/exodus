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
                                <label for="name">@lang('app.branch.name')</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $branchData->name }}">
                            </div>
                        </div>
 <div class="col-md-4">
                            <div class="form-group">
                                <label for="unique_id">@lang('app.branch.unique_id')</label>
                                <input type="number" class="form-control" id="unique_id" name="unique_id" value="{{ $branchData->unique_id }}">
                            </div>
                        </div>
                         
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="checkbox" class="form-control" id="paired" name="paired" @if ($branchData->paired == 1) checked @endif>
                                <label for="paired">@lang('app.branch.paired')</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address" class="required">@lang('app.branch.address')</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ $branchData->address }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="email">@lang('app.branch.email')</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $branchData->email }}">
                            </div>
                        </div>
                       
                                <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('app.branch.phone')</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="phone" value="{{ $branchData->phone }}">
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                                </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="required">@lang('app.branch.desc')</label>
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <textarea  class="form-control" name="desc" rows="4" cols="50">{{ $branchData->desc }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-2">
                                <div class="form-group">
                                <label class="required">@lang('app.branch.contact_person')</label>
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="contact_person" value="{{ $branchData->contact_person }}">
                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label for="exampleInputPassword1">@lang('app.branch.image')</label>
                                <div class="card">
                                    <div class="card-body">
                                        <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" 
                                            class="dropify" data-default-file="{{ old('image') ? asset('user-uploads/branches/'.old('image')) : asset('user-uploads/branches/'.$branchData->image) }}" 
                                        />
                                    </div>
                                </div>
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
                url: '{{route('admin.branches.update', $branchData->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>

@endpush