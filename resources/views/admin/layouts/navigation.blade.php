@php
  

if(str_contains((string)request()->path(),'translations')){
  $main_menu = 'settings';
  $sub_menu = 'translations';
  $sub_menu_1 = '';
}
 
@endphp 

<aside class="main-sidebar">
  <!-- sidebar-->
  <section class="sidebar">
    <!-- sidebar menu-->
    <ul class="sidebar-menu" data-widget="tree"> 
          <li class="{{'dashboard' == $main_menu ? 'active' : '' }}">
        <a href="{{url('/dashboard')}}">
          <i class="fa fa-tachometer"></i> <span>@lang('pages_names.dashboard')</span>
        </a>
      </li> 
      <li class="treeview {{ 'plf_profile' == $main_menu ? 'active menu-open' : '' }}">
        <a href="javascript: void(0);">
        <i class="fa fa-users" aria-hidden="true"></i>
          <span> Manage PLF/VO</span>  
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu"> 
        <li class="{{'plf_profile' == $sub_menu ? 'active' : '' }}">
        <a href="{{url('/plf-profile')}}">
          <i class="fa fa-tachometer"></i> <span>Profile </span>
        </a>
      </li> 
      <li class="{{'plf_profile_open' == $sub_menu ? 'active' : '' }}">
        <a href="{{url('/plf-profile/open-balance')}}">
          <i class="fa fa-tachometer"></i> <span>Open Balance</span>
        </a>
      </li> 
        </ul>
      </li> 

      <li class="treeview {{ 'clf_profile' == $main_menu ? 'active menu-open' : '' }}">
        <a href="javascript: void(0);">
        <i class="fa fa-users" aria-hidden="true"></i>
          <span> Manage BLF/CLF</span>  
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu"> 
      
      <li class="{{'clf_profile' == $sub_menu ? 'active' : '' }}">
        <a href="{{url('/clf-profile')}}">
          <i class="fa fa-tachometer"></i> <span>Profile</span>
        </a>
      </li> 
      <li class="{{'clf_profile_open' == $sub_menu ? 'active' : '' }}">
        <a href="{{url('/clf-profile/open-balance')}}">
          <i class="fa fa-tachometer"></i> <span>Open Balance </span>
        </a>
      </li> 
        </ul>
      </li> 
            
     
 
      <li class="treeview {{ 'users' == $main_menu ? 'active menu-open' : '' }}">
        <a href="javascript: void(0);">
        <i class="fa fa-users" aria-hidden="true"></i>
          <span> Manage Fund</span>  
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu"> 
        <li class="{{'user_details' == $sub_menu ? 'active' : '' }}">
        <a href="{{url('/fund-type')}}">
                <i class="fa fa-user-circle-o"></i> <span>Fund Type</span>
              </a>
            </li>   
        </ul>
      </li> 
      
     
  </section>
</aside>
