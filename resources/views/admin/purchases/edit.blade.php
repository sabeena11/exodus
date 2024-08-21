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
                        
                        <div class="form-group">
                            <label for="user">@lang('app.purchases.user_id')</label>
                            <select class="form-control select"  style="width: 100% !important" name="user_id" id="user_id">
                                @foreach ($users as $data)
                                    <option value="{{$data->id}}"  @if ($purchaseData->user_id == $data->id)selected @endif> {{$data->name}}</option> 
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="purchase_id">@lang('app.purchases.purchase_id')</label>
                            <input type="number" class="form-control" id="purchase_id" name="purchase_id" value="{{ $purchaseData->purchase_id }}">
                        </div>

                        <div class="form-group">
                            <label for="master_id">@lang('app.purchases.master_id')</label>
                            <input type="number" class="form-control" id="master_id" name="master_id" value="{{ $purchaseData->master_id }}">
                        </div>

                        <div class="form-group">
                            <label for="points">@lang('app.purchases.points')</label>
                            <input type="number" class="form-control" id="points" name="points" value="{{ $purchaseData->points }}">
                        </div>

                        <div class="form-group">
                            <label for="date">@lang('app.purchases.date')</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ $purchaseData->date }}">
                        </div>

                        <div class="form-group">
                            <label for="bill_no">@lang('app.purchases.bill_no')</label>
                            <input type="text" class="form-control" id="bill_no" name="bill_no" value="{{ $purchaseData->bill_no }}">
                        </div>

                        <div class="form-group">
                            <label for="branch">@lang('app.purchases.branch_id')</label>
                            <select class="form-control select" name="branch_id" id="branch_id">
                                @foreach ($branch as $data)
                                    <option value="{{$data->id}}"  @if ($purchaseData->branch_id == $data->id)selected @endif> {{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="end_device_id">@lang('app.purchases.end_device_id')</label>
                            <input type="number" class="form-control" id="end_device_id" name="end_device_id" value="{{ $purchaseData->end_device_id }}">
                        </div>

                        <div class="form-group">
                            <label for="total">@lang('app.purchases.total')</label>
                            <input type="number" class="form-control" id="total" name="total" value="{{ $purchaseData->total }}">
                        </div>

                        <div class="form-group">
                            <label for="gross_amount">@lang('app.purchases.gross_amount')</label>
                            <input type="number" class="form-control" id="gross_amount" name="gross_amount" value="{{ $purchaseData->gross_amount }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="discount">@lang('app.purchases.discount')</label>
                            <input type="number" class="form-control" id="discount" name="discount" value="{{ $purchaseData->discount }}">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                url: '{{route('admin.purchases.update', $purchaseData->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });

        $(document).ready(function() {
            $('.select').select2();
        });
    </script>

@endpush