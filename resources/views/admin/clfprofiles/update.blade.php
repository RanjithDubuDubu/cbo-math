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
                            <a href="{{ url('clf-profile/open-balance') }}">
                                <button class="btn btn-danger btn-sm pull-right" type="submit">
                                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                                    @lang('view_pages.back')
                                </button>
                            </a>
                        </div>

                        <div class="col-sm-12" style="  background: #fff; padding: 15px;">

                            <form method="post" class="form-horizontal" action="{{ url('clf-profile/open-balance/update', $results->id) }}"
                                enctype="multipart/form-data">
                                <h3 style="
                                    margin-bottom: 20px;
                                    font-weight: 600;
                                    /* background: grey; */
                                    /* border-bottom: 3px solid red; */
                                    /* width: 215px; */
                                ">{{$results->profile->BlockDetails->blockname}} Block</h3>
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Total Amount Received <span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" id="amount" name="amount"
                                                value="" required=""
                                                placeholder="Enter the amount">
                                            <span class="text-danger">{{ $errors->first('name') }}</span>

                                        </div>
                                    </div> 

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Current Opening Balance (As on 31.03.2024) <span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" id="balance" name="balance"
                                                value="{{ old('email', $results->email) }}" required=""
                                                placeholder="Enter the amount">
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        </div>
                                    </div> 

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="country">Upload Passbook Front end Copy
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input class="form-control" type="file" id="front_copy" name="front_copy"
                                                 required="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Upload Passbook Back Copy <span class="text-danger">*</span></label>
                                            <input class="form-control" type="file" id="back_copy" name="back_copy"
                                                 required="">
                                            <span class="text-danger">{{ $errors->first('mobile') }}</span>

                                        </div>
                                    </div>

                                    <!-- <div class="col-6">
                                        <div class="form-group">
                                            <label for="profile_picture">@lang('view_pages.profile')</label><br>
                                            <img class="user-image" id="blah" src="{{asset( $results->profile_picture) }}" alt=" "><br>
                                            <input type="file" id="profile" onchange="readURL(this)" name="profile_picture"
                                                style="display:none">
                                            <button class="btn btn-primary btn-sm" type="button"
                                                onclick="$('#profile').click()" id="upload">@lang('view_pages.browse')</button>
                                            <button class="btn btn-danger btn-sm" type="button" id="remove_img"
                                                style="display: none;">@lang('view_pages.remove')</button><br>
                                            <span class="text-danger">{{ $errors->first('profile_picture') }}</span>
                                        </div>
                                    </div> -->
                                </div>


                                <div class="form-group">
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-sm pull-right m-5" type="submit">
                                            @lang('view_pages.update')
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
