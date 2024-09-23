@extends('admin.layouts.app')
@section('title', 'Main page')

@section('content')

    <!-- Start Page content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">

                        <div class="box-header with-border">
                            <a href="{{ url('users') }}">
                                <button class="btn btn-danger btn-sm pull-right" type="submit">
                                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                                    @lang('view_pages.back')
                                </button>
                            </a>
                        </div>

                        <div class="col-sm-12">

                            <form method="post" class="form-horizontal" action="{{ url('users/store') }}"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                        <label for="voName" class="form-label">VO Name as per Passbook <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="voName" name="voName" placeholder="Enter VO Name">

                                        </div>
                                    </div>
                                    
                                
                                   

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                        <label for="ifsc" class="form-label">IFSC <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="ifsc" name="ifsc" placeholder="Enter IFSC"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-sm pull-right m-5" type="submit">
                                           Fetch Bank Details
                                        </button>
                                    </div>
                                </div>

                                    <!-- <div class="col-6">
                                        <div class="form-group">
                                            <label for="country">@lang('view_pages.select_country')
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="country" id="country" class="form-control" required>
                                                <option value="">@lang('view_pages.select_country')</option>
                                                @foreach ($countries as $key => $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ old('country') == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{ $errors->first('country') }}</span>

                                        </div>
                                    </div> -->

                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">@lang('view_pages.mobile') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="mobile" name="mobile"
                                                value="{{ old('mobile') }}" required=""
                                                placeholder="@lang('view_pages.enter_mobile')">
                                            <span class="text-danger">{{ $errors->first('mobile') }}</span>

                                        </div>
                                    </div> -->

                                    {{-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="state">@lang('view_pages.state')</label>
                                            <input class="form-control" type="text" id="state" name="state"
                                                value="{{ old('state') }}" required=""
                                                placeholder="@lang('view_pages.enter_state')">
                                            <span class="text-danger">{{ $errors->first('state') }}</span>

                                        </div>
                                    </div> 
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="city">@lang('view_pages.city')</label>
                                            <input class="form-control" type="text" id="city" name="city"
                                                value="{{ old('city') }}" required=""
                                                placeholder="@lang('view_pages.enter_city')">
                                            <span class="text-danger">{{ $errors->first('city') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="postal_code">@lang('view_pages.postal_code')</label>
                                            <input class="form-control" type="number" id="postal_code" name="postal_code"
                                                value="{{ old('postal_code') }}" required=""
                                                placeholder="@lang('view_pages.enter_postal_code')">
                                            <span class="text-danger">{{ $errors->first('postal_code') }}</span>

                                        </div>
                                    </div> --}}
                                </div>

                            <!--   <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password">@lang('view_pages.password') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="password" id="password" name="password"
                                                value="" required="" placeholder="@lang('view_pages.enter_password')">
                                            <span class="text-danger">{{ $errors->first('password') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="confirm_password">@lang('view_pages.confirm_password') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="password" id="password_confirmation"
                                                name="password_confirmation" required=""
                                                placeholder="@lang('view_pages.enter_confirm_password')">
                                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>

                                        </div>
                                    </div> --> 


                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="profile_picture">@lang('view_pages.profile')</label><br>
                                            <img id="blah" src="#" alt=" "><br>
                                            <input type="file" id="profile" onchange="readURL(this)" name="profile_picture"
                                                style="display:none">
                                            <button class="btn btn-primary btn-sm" type="button"
                                                onclick="$('#profile').click()" id="upload">@lang('view_pages.browse')</button>
                                            <button class="btn btn-danger btn-sm" type="button" id="remove_img"
                                                style="display: none;">@lang('view_pages.remove')</button><br>
                                            <span class="text-danger">{{ $errors->first('profile_picture') }}</span>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-sm pull-right m-5" type="submit">
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

@endsection
