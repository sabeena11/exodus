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
                                <label for="point">@lang('app.coupon.point')</label>
                                <input type="number" class="form-control w-25" id="point" name="point"
                                    value='{{ $couponData->point }}'>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputPassword1">@lang('app.coupon.image')</label>
                                <div class="card">
                                    <div class="card-body">
                                        <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg"
                                            class="dropify"
                                            data-default-file="{{ old('image') ? asset('user-uploads/coupon/' . old('image')) : asset('user-uploads/coupon/' . $couponData->image) }}" />
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">@lang('app.coupon.title')</label>
                                <input type="email" class="form-control" id="title" name="title"
                                    value='{{ $couponData->title }}'>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="desc">@lang('app.gifts.desc')</label>
                                <textarea class="form-control" id="desc" name="desc" rows="4">{{ $couponData->desc }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="startdate">@lang('app.coupon.startdate')</label>
                                <input type="datetime-local" class="form-control w-25" id="startdate" name="start_date"><br>
                                {{-- <input type="time" class="form-control w-25" id="startdate" name="start_date"> --}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="enddate">@lang('app.coupon.enddate')</label>
                                <input type="datetime-local" class="form-control w-25" id="enddate" name="end_date"><br>
                                {{-- <input type="time" class="form-control w-25" id="enddate" name="end_date"> --}}
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
                url: '{{ route('admin.coupons.update', $couponData->id) }}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>
@endpush
