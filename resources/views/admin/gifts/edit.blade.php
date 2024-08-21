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
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="branch">@lang('app.gifts.branch')</label>
                                    <select class="form-control select2" name="branch_id" id="branch">
                                    @foreach ($branches as $data)
                                    <option value="{{ $data->id }}"  @if ($giftData->branch_id == $data->id)selected @endif>
                        {{ $data->name }}
                    </option>
                                        
                                    @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="user">@lang('app.gifts.user')</label>
                                    <select class="form-control select2" name="user_id" id="user">
                                    @foreach ($users as $data)
                                    <option value="{{ $data->mobile }}"  @if ($giftData->user_id == $data->id)selected @endif>
                        {{ $data->name }}
                    </option>
                                    @endforeach
</select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="user">@lang('app.gifts.categories')</label>
                                    <select class="form-control select2" name="categories" id="categories">


                                        @foreach ($categories as $category)
                                            <option value="{{ $category->gift_category_name }}"
                                                data-points="{{ $category->gift_category_points }}"
                                                {{ $category->gift_category_name == $selectedcategoryId ? 'selected' : '' }}>
                                                {{ $category->gift_category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="points">@lang('app.gifts.points')</label>
                                    <input type="number" class="form-control select2" id="points" name="points"
                                        value="{{ $giftData->points }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-5">
                        <div class="form-group">
                            <label for="desc">@lang('app.gifts.desc')</label>
                            <textarea class="form-control" name="desc" rows="4" required>{{ $giftData->desc }}</textarea>

                        </div>
                </div>
             </div>

                <button type="submit" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                    @lang('app.save')
                </button>
                <button type="button" id="save-and-continue"  class="btn btn-success waves-effect waves-light m-r-10">@lang('app.saveandcontinue')</button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/select2/select2.js') }}"></script>
    <script>
        $('#points').on('input', function() {
    // Check if the entered value is negative
    if (parseInt($(this).val()) < 0) {
        // If negative, set the value to 0
        $(this).val(0);
    }
});
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
                url: '{{ route('admin.gifts.update', $giftData->id) }}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });

        $(document).ready(function() {
            $('#categories').change(function() {
                var selectedCategory = $(this).find('option:selected');
                var points = selectedCategory.data('points');
                $('#points').val(points);
            });
        });

        $('#categories').select2({
            placeholder: "Select a category", // Placeholder text
            // Option to clear selection
        });
        $('#user').select2({
            placeholder: "Select a user", // Placeholder text
            // Option to clear selection
        });
        $('#branch').select2({
            placeholder: "Select a branch", // Placeholder text
            // Option to clear selection
        });

        $('#save-and-continue').click(function() {
    // Set the hidden input value
    $('input[name="save_and_continue"]').val(1);

    // Serialize the form data
    var formData = $('#editSettings').serialize();

    // Make an AJAX request to save the data
    $.ajax({
        url: '{{ route('admin.gifts.update', $giftData->id) }}',
        type: 'POST',
        data: formData,
        success: function(response) {
             // Show a success message
             toastr.success('Gift Points update successfully.');
            // Redirect to the index page
            window.location.href = '{{ route('admin.gifts.create') }}';
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error(xhr.responseText);
        }
    });
});
    </script>
@endpush
