<div class="box-body no-padding">
    <div class="table-responsive">
      <table class="table table-hover">
    <thead>
    <tr>


    <th> @lang('view_pages.s_no')
    <span style="float: right;">

    </span>
    </th>

    <th> VO Name
    <span style="float: right;">
    </span>
    </th>
  <!--   <th> @lang('view_pages.email')
    <span style="float: right;">
    </span>
    </th> -->
    <th> Bank Name
    <span style="float: right;">
    </span>
    </th>
    <th>Branch Name
    <span style="float: right;">
    </span>
    </th>
    <th>Account Number
    <span style="float: right;">
    </span>
    </th> 
    <th>Account Type
    <span style="float: right;">
    </span>
    </th>  
    <th>Status
    <span style="float: right;">
    </span>
    </th>  
    <th>Action
    <span style="float: right;">
    </span>
    </th>
  
    </tr>
    </thead>
    <tbody>


    @php  $i= $results->firstItem(); @endphp

    @forelse($results as $key => $result)

    <tr>
    <td>{{ $i++ }} </td>
    <td> {{$result->PanchayatDetails->villagename}}</td>  
    <td>
    @if($result->vo_name)
    {{$result->vo_name}} 
    @else
    -------
    @endif    
    </td> 
    <td>{{$result->vo_id}}</td> 
    <td>{{$result->vo_code}}</td>   
    <td>{{$result->total_shg}}</td>   
    <td>@if($result->is_completed == 0)
<button class="btn btn-success btn-sm" style="  background: #ff9900;   border-color: transparent;
">Incomplete</button> 
    @else
    <button class="btn btn-success btn-sm" style="  background: green;   border-color: transparent;
">Completed</button>
@endif
</td>   
    
<td class="overflow-scroll">

<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('view_pages.action')
</button>
    <div class="dropdown-menu">
    
        <a class="dropdown-item" href="{{url('plf-profile/vo_profile',$result->id)}}">
        <i class="fa fa-pencil"></i>Edit</a> 
        <a class="dropdown-item sweet-delete" href="{{url('plf-profile/vo_profile',$result->id)}}">
        <i class="fa fa-trash-o"></i>View</a>
    </div>
</div>

</td>
   
    </tr>
   @empty
        <tr>
            <td colspan="11">
                <p id="no_data" class="lead no-data text-center">
                    <img src="{{asset('assets/img/dark-data.svg')}}" style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
                    <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
                </p>
            </td>
        </tr>
    @endforelse

    </tbody>
    </table>


    <div class="text-right">
<span  style="float:right">
{{$results->links()}}
</span>
</div>
</div></div>
