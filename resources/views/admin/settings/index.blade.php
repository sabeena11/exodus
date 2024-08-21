@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="editSettings" class="ajax-form">
                        @csrf
                        @method('PUT')

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="company_name" class="required">@lang('app.companySettings.companyName')</label>
                                <input type="text" class="form-control" id="company_name" name="company_name"
                                    value="{{ $global->company_name }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="company_email" class="required">@lang('app.companySettings.companyEmail')</label>
                                <input type="email" class="form-control" id="company_email" name="company_email"
                                    value="{{ $global->company_email }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="company_phone" class="required">@lang('app.companySettings.companyPhone')</label>
                                <input type="tel" class="form-control" id="company_phone" name="company_phone"
                                    value="{{ $global->company_phone }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="required">@lang('app.companySettings.companyWebsite')</label>
                                <input type="text" class="form-control" id="website" name="website"
                                    value="{{ $global->website }}">
                            </div>

                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputPassword1">@lang('app.companySettings.companyLogo')</label>
                                <div class="card">
                                    <div class="card-body">
                                        <input type="file" id="input-file-now" name="logo" class="dropify"
                                            @if (is_null($global->logo)) data-default-file="{{ asset('app-logo.png') }}"
                                               @else
                                                   data-default-file="{{ asset('user-uploads/app-logo/' . $global->logo) }}" @endif />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address" class="required">@lang('app.companySettings.companyAddress')</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{ $global->address }}">
                            </div>
                        </div>

 <div class="col-md-4">
                            <div class="form-group">
                                <label for="facebook_url">@lang('app.companySettings.facebookUrl')</label>
                                <input type="text" class="form-control" id="facebook_url" name="facebook_url"
                                    value="{{ $global->facebook_url }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="linkedin_url">@lang('app.companySettings.linkedinUrl')</label>
                                <input type="text" class="form-control" id="linkedin_url" name="linkedin_url"
                                    value="{{ $global->linkedin_url }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="instagram_url">@lang('app.companySettings.instagramUrl')</label>
                                <input type="text" class="form-control" id="instagram_url" name="instagram_url"
                                    value="{{ $global->instagram_url }}">
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="instagram_url">@lang('app.companySettings.twitterUrl')</label>
                                <input type="text" class="form-control" id="twitter_url" name="twitter_url"
                                    value="{{ $global->twitter_url }}">
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
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip()
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());

        });
        // For select 2
        $(".select2").select2();

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
                url: '{{ route('admin.settings.update', ['1']) }}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>
@endpush
