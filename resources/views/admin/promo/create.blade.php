@extends('admin.layouts.app')
@section('title', 'Main page')

@section('content')
{{-- {{session()->get('errors')}} --}}

<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{!! asset('assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}">
<!-- Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e4e4e4;
    border: 1px solid #aaa;
    border-radius: 4px;
    box-sizing: border-box;
    display: inline-block;
    margin-left: 5px;
    margin-top: 5px;
    padding: 0;
    padding-left: 20px;
    position: relative;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: bottom;
    white-space: nowrap;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #398bf7;
    border-color: #367fa9;
    /* padding: 2px 15px; */
    color: #000000;
}
</style>
    <!-- Start Page content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">

                        <div class="box-header with-border">
                            <a href="{{ url('promo') }}">
                                <button class="btn btn-danger btn-sm pull-right" type="submit">
                                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                                    @lang('view_pages.back')
                                </button>
                            </a>
                        </div>

                        <div class="col-sm-12">

                            <form method="post" class="form-horizontal" action="{{ url('promo/store') }}">
                                @csrf

                                <div class="row">
                                    <!-- <div class="col-6">
                                        <div class="form-group">
                                            <label for="admin_id">@lang('view_pages.select_area')
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="service_location_id" id="service_location_id" class="form-control"
                                                required>
                                                <option value="">@lang('view_pages.select_area')</option>
                                                @foreach ($cities as $key => $city)
                                                    <option value="{{ $city->id }}" {{ old('service_location_id') == $city->id ? 'selected' : '' }} >{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{ $errors->first('service_location_id') }}</span>
                                        </div>
                                    </div> -->
                                    <div class="col-6">
                                        <div class="form-group">
                                        <label for="select_area">@lang('view_pages.select_area')
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="service_location_id[]" id="service_location_id" class="form-control select2" multiple="multiple" data-placeholder="@lang('view_pages.select_area')" required>
                                                @foreach ($cities as $key => $city)
                                                    <option value="{{ $city->id }}" {{ old('service_location_id') == $city->id ? 'selected' : '' }} >{{ $city->name }}</option>
                                                @endforeach
                                                </select>
                                            <span class="text-danger">{{ $errors->first('service_location_id') }}</span>
                                        </div>
                                    </div>
                                  

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="code">@lang('view_pages.code') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="code" name="code"
                                                value="{{ old('code') }}" required
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.code')">
                                            <span class="text-danger">{{ $errors->first('code') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="minimum_trip_amount">@lang('view_pages.minimum_trip_amount') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="minimum_trip_amount" name="minimum_trip_amount"
                                                value="{{ old('minimum_trip_amount') }}" required
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.minimum_trip_amount')">
                                            <span class="text-danger">{{ $errors->first('minimum_trip_amount') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="maximum_discount_amount">@lang('view_pages.maximum_discount_amount') </label>
                                            <input class="form-control" type="text" id="maximum_discount_amount" name="maximum_discount_amount"
                                                value="{{ old('maximum_discount_amount') }}"
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.maximum_discount_amount')">
                                            <span class="text-danger">{{ $errors->first('maximum_discount_amount') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="discount_percent">@lang('view_pages.discount_percent') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="discount_percent" name="discount_percent"
                                                value="{{ old('discount_percent') }}" required=""
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.discount_percent')">
                                            <span class="text-danger">{{ $errors->first('discount_percent') }}</span>
                                        </div>
                                    </div>
                                </div>

                               <!--  <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="total_uses">@lang('view_pages.total_uses') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="total_uses" name="total_uses"
                                                value="{{ old('total_uses') }}" required
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.total_uses')">
                                            <span class="text-danger">{{ $errors->first('total_uses') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="uses_per_user">@lang('view_pages.uses_per_user') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="uses_per_user" name="uses_per_user"
                                                value="{{ old('uses_per_user') }}" required=""
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.uses_per_user')">
                                            <span class="text-danger">{{ $errors->first('uses_per_user') }}</span>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="from">@lang('view_pages.from') <span class="text-danger">*</span></label>
                                            <input class="form-control datepicker" type="text" id="from" name="from"
                                                value="{{ old('from') }}" required
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.from')"  autocomplete="off">
                                            <span class="text-danger">{{ $errors->first('from') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="to">@lang('view_pages.to') <span class="text-danger">*</span></label>
                                            <input class="form-control datepicker" type="text" id="to" name="to"
                                                value="{{ old('to') }}" required=""
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.to')"  autocomplete="off">
                                            <span class="text-danger">{{ $errors->first('to') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-md pull-right m-5" type="submit">
                                            @lang('view_pages.save')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</div>
    <!-- content -->


<script src="{{asset('assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<script>
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      startDate: 'today'
    });
</script>

<script>
$( '#multiple-select-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    closeOnSelect: false,
} );
</script>
@endsection
