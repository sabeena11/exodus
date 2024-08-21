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
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="branch">@lang('app.gifts.branch')</label>
                                <select class="form-control select2" name="branch_id" id="branch">
                                @foreach ($branches as $data)
                                        <option value="{{ $data->id }}"> {{ $data->name }}</option>
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
                                        <option value="{{ $data->mobile }}"> {{ $data->name }}</option>
                                    @endforeach
</select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="categories">@lang('app.gifts.categories')</label>
                                <select class="form-control select2" name="categories" id="categories">
                                    <option value=""></option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->gift_category_name }}" data-points="{{ $category->gift_category_points }}">{{ $category->gift_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="points">@lang('app.gifts.points')</label>
                                <input type="number" class="form-control" id="points" name="points">
                            </div>
                        </div>
                    </div>
           
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="desc">@lang('app.gifts.desc')</label>
                                <textarea class="form-control" name="desc" rows="4" required></textarea>
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
</div>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>

    <!-- Include Select2 JS -->
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
                url: '{{ route('admin.gifts.store') }}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });

        $('.field-icon').click(function() {
            if ($(this).hasClass('fa-eye-slash')) {
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
                $('#password').attr('type', 'text');
            } else {
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');
                $('#password').attr('type', 'password');
            }
        });

        $(document).ready(function() {
            $('#categories').change(function() {
                var selectedCategory = $(this).find('option:selected');
                var points = selectedCategory.data('points');
                $('#points').val(points);
            });
        });

        $('#categories, #branch').select2({
            placeholder: "Select an option",
        });

        $('#user').select2({
            matcher: function(params, data) {
                if ($.trim(params.term) === "") {
                    return data;
                }
                if (typeof data.text === "undefined") {
                    return null;
                }
                var q = params.term.toLowerCase();
                if (data.text.toLowerCase().indexOf(q) > -1 || data.id.toLowerCase().indexOf(q) > -1)
                {
                    return $.extend({}, data, true);
                }
                return null;
            },
            placeholder: "Select an option",
        });


     $('#save-and-continue').click(function() {
    // Set the hidden input value
    $('input[name="save_and_continue"]').val(1);

    // Serialize the form data
    var formData = $('#editSettings').serialize();

    // Make an AJAX request to save the data
    $.ajax({
        url: '{{ route('admin.gifts.store') }}',
        type: 'POST',
        data: formData,
        success: function(response) {
             // Show a success message
             toastr.success('Gift Points saved successfully.');
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
