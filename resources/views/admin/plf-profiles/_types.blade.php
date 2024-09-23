
<div class="table-responsive"><div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>


                                                    <th> S.No
                                                        <span style="float: right;"></span>
                                                    </th>

                                                    <th> Booking ID
                                                        <span style="float: right;"></span>
                                                    </th>
                                                    <!-- <th> Tansport Type<span style="float: right;">
</span>
</th> -->
                                                    <th> Check-in 
                                                        <span style="float: right;"> </span>
                                                    </th>
                                                    <th> check-out
                                                        <span style="float: right;"></span>
                                                    </th>
                                                 
                                                    <th> Status
                                                        <span style="float: right;"></span>
                                                    </th>

                                                    <th> Action<span style="float: right;">
</span>
                                                    </th>

                                                </tr>
                                            </thead>
                                       
<tbody>
 @if(count($results)<1)
    <tr>
        <td colspan="11">
        <p id="no_data" class="lead no-data text-center">
        <img src="{{asset('assets/img/dark-data.svg')}}" style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
     <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
 </p>
    </tr>
    @else

@php  $i= $results->firstItem(); @endphp

@foreach($results as $key => $result)

<tr>
<td>{{ $i++ }} </td>
<td> {{$result->booking_id}}</td> 

<td><?php echo date('Y-m-d', strtotime($result->checkin_date)); ?></td>
<td><?php echo date('Y-m-d', strtotime($result->checkout_date)); ?></td> 
<td>@if($result->status == 0)
@if($result->is_admin_approve == 0)
<button class="btn btn-success btn-sm" style="  background: #ff9900;   border-color: transparent;
">Waiting for admin approval</button>
@else
<button class="btn btn-success btn-sm" style="  background: #ff9900;   border-color: transparent;
">Booked</button>
@endif

    @elseif($result->status == 1)
    <button class="btn btn-success btn-sm" style="  background: #ff9900;   border-color: transparent;
">Booked</button>
    @elseif($result->status == 2)
    <button class="btn btn-success btn-sm" style="  background: red;   border-color: transparent;
">Cancelled</button>
    @else<button class="btn btn-success btn-sm" style="  background: green;   border-color: transparent;
">Completed</button>
@endif
</td>   
<td class="overflow-scroll">

    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('view_pages.action')
    </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{url('company/edit',$result->id)}}">
            <i class="fa fa-pencil"></i>@lang('view_pages.edit')</a>
             @if($result->active)
            <a class="dropdown-item" href="{{url('company/toggle_status',$result->id)}}">
            <i class="fa fa-dot-circle-o"></i>@lang('view_pages.inactive')</a>
            @else
            <a class="dropdown-item" href="{{url('company/toggle_status',$result->id)}}">
            <i class="fa fa-dot-circle-o"></i>@lang('view_pages.active')</a>
            @endif

            <a class="dropdown-item sweet-delete" href="{{url('company/delete',$result->id)}}">
            <i class="fa fa-trash-o"></i>@lang('view_pages.delete')</a>
        </div>
    </div>

    </td>
</tr>
@endforeach
@endif
</tbody>
</table>
<div class="text-right">
<span  style="float:right">
{{$results->links()}}
</span>
</div></div></div></div>
