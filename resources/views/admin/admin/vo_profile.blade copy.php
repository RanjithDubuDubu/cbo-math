@extends('admin.layouts.app')

@section('title', 'Admin Profile')
@section('content')
<style>
   h4.section-header {
    /* background: #0a7e8c; */
    padding: 10px;
    max-width: 240px;
    color: #0a7e8c;
    border-radius: 3px;
}
.hidden { display: none; }
.modal-content {
    min-width: 500px;
    max-width: 100%;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    animation: slideIn 0.5s ease-in-out;
}
@media (min-width: 576px) {
    .modal-dialog {
        max-width: 75% !important;
        margin: 1.75rem auto;
    }
}
@media (min-width: 768px) {
    .modal-dialog {
        width: 100% !important;
        margin: 30px auto;
    }
}
.modal-dialog.actv{
    width: 25% !important;
}

      /* Basic styling for the tabs */
      button.map-button {
            float: right;
            padding: 5px 18px 5px 20px;
            border: #e8e5e0;
            background: #0a7e8c;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }
      .tab-containers {
            width: 100%;
            margin: 0 auto;
        }

        .tabss {
            display: flex;
            border-bottom: 2px solid #007bff;
        }

        .tab1 {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #f1f1f1;
            border: 1px solid #007bff;
            border-bottom: none;
            flex: 1;
            text-align: center;
            font-weight: bold;
        }

        .tab1.active {
            background-color: #007bff;
            color: white;
        }

        .tab-content1 {
            display: none;
            padding: 20px;
            border: 1px solid #007bff;
            border-top: none;
            background-color: #ffffff;
        }

        .tab-content1.active {
            display: block;
        }
         /* Styling for the mapped container */
         .mapped-container {
            margin-top: 20px;
        }

        .mapped-title {
            font-size: 21px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .search-container {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-container input[type="text"] {
            padding: 8px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        th input[type="checkbox"] {
            margin-right: 10px;
        }
    
.image {
    height: 80px;
    width: 80px;
    /* border-radius: 50%; */
}
img {
    max-width: 100%;
    border-radius: 50%;
}
ul.nav.nav-tabs li {
    font-size: 12px !important;
}
@media (max-width: 768px) {
    .col-sm-6 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }
}

[type="checkbox"]+label:before, [type="checkbox"]:not(.filled-in)+label:after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 18px;
    height: 18px;
    z-index: 0;
    border: 2px solid #5a5a5a;
    border-radius: 1px;
    margin-top: 0px !important;
    -webkit-transition: 0.2s;
    -o-transition: 0.2s;
    transition: 0.2s;
}
i{
    color:#0A7E8C;
}
.row {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px; 
}


.profile-nav .user-heading {
    background: #fbc02d;
    color: #fff;
    border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    padding: 30px;
    text-align: center;
}

.profile-nav .user-heading.round a  {
    border-radius: 50%;
    -webkit-border-radius: 50%;
    border: 10px solid rgba(255,255,255,0.3);
    display: inline-block;
}

.profile-nav .user-heading a img {
    width: 112px;
    height: 112px;
    border-radius: 50%;
    -webkit-border-radius: 50%;
}

.profile-nav .user-heading h1 {
    font-size: 22px;
    font-weight: 300;
    margin-bottom: 5px;
}

.profile-nav .user-heading p {
    font-size: 12px;
}

.profile-nav ul {
    margin-top: 1px;
}

.profile-nav ul > li {
    border-bottom: 1px solid #ebeae6;
    margin-top: 0;
    line-height: 30px;
}

.profile-nav ul > li:last-child {
    border-bottom: none;
}

.profile-nav ul > li > a {
    border-radius: 0;
    -webkit-border-radius: 0;
    color: #89817f;
    border-left: 5px solid #fff;
}

.profile-nav ul > li > a:hover, .profile-nav ul > li > a:focus, .profile-nav ul li.active  a {
    background: #f8f7f5 !important;
    border-left: 5px solid #fbc02d;
    color: #89817f !important;
}

.profile-nav ul > li:last-child > a:last-child {
    border-radius: 0 0 4px 4px;
    -webkit-border-radius: 0 0 4px 4px;
}

.profile-nav ul > li > a > i{
    font-size: 16px;
    padding-right: 10px;
    color: #bcb3aa;
}

.r-activity {
    margin: 6px 0 0;
    font-size: 12px;
}


.p-text-area, .p-text-area:focus {
    border: none;
    font-weight: 300;
    box-shadow: none;
    color: #c3c3c3;
    font-size: 16px;
}
.col-3 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 25%;
    flex: 0 0 20% !important;
    max-width: 50%;
}
 
.col-7.col-sm-6 {
    max-width: 58% !important;
    flex: 0 0 70%;
}
.profile-align{
    line-height:22px;
}
.box-profile.nav-tabs-custom>.nav-tabs {
    margin: 0;
    border-bottom: none;
    border-radius: 0;
    background-color: transparent !important;
    /* width: 314px !important;  */
    display: flex;
}

.nav-tabs-custom>.nav-tabs>li>a.active:hover, .nav-tabs-custom>.nav-tabs>li>a.active {
    background-color: #0a7e8c;
    color: #455a64;
    color: white !important;
}
.box-profile.nav-tabs-custom>.nav-tabs>li {
    margin-bottom: 0px;
    margin-right: 0px !important;
}
.tab-content {
    background: #fff !important;
    border-radius: 3px;
}
.nav-tabs-custom>.nav-tabs>li>a:hover, .nav-tabs-custom>.nav-tabs>li>a {
    background: #e5e5e5;
    color: black !important;
}
#formatted_by,#Registration1Act,#VOActive,#habitation,#habitation1,#shg_group,#shg_member,.select_ec,#service_provider_name,#banks{
  width: 100%;
  border: 1px solid #e1dede;
  padding: 6px;
  cursor: pointer;
}
input[type="checkbox"] {
  cursor: pointer;
}
.switch2, .switch3,.switch4,.switch6,.switch8,.switch9,.switch4.actv {
position: relative;
top:-20px;
display: inline-block;
margin: 0 5px;
}

.switch2 > span,.switch3 > span,.switch4 > span,.switch6 > span,.switch8 > span,.switch9 > span,.switch,.switch4.actv > span {
position: absolute;
top:29px;
pointer-events: none;
font-family: 'Helvetica', Arial, sans-serif;
font-weight: bold;
font-size: 12px;
text-transform: uppercase;
text-shadow: 0 1px 0 rgba(0, 0, 0, .06);
width: 50%;
text-align: center;
}

input.check-toggle-round-flat:checked ~ .off {
color: #fff;
}

input.check-toggle-round-flat:checked ~ .on {
color: #fff;
}

.switch2 > span.on,.switch3 > span.on,.switch4 > span.on,.switch6 > span.on,.switch8 > span.on,.switch9 > span.on,.switch4.actv > span.on {
left: 0;
padding-left: 2px;
color: #fff;
}

.switch2 > span.off,.switch3 > span.off,.switch4 > span.off,.switch6 > span.off,.switch8 > span.off,.switch9 > span.off,.switch4.actv > span.off {
right: 0;
padding-right: 4px;
color: #000;
}

.check-toggle {
position: absolute;
margin-left: -9999px;
visibility: hidden;
}
.check-toggle + label {
display: block;
position: relative;
cursor: pointer;
outline: none;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;
}

input.check-toggle-round-flat + label {
padding: 2px;
width: 97px;
height: 30px;
background-color:#d4d7d4;
-webkit-border-radius: 60px;
-moz-border-radius: 60px;
-ms-border-radius: 60px;
-o-border-radius: 60px;
border-radius: 60px;
}
input.check-toggle-round-flat + label:before, input.check-toggle-round-flat + label:after {
display: block;
position: absolute;
content: "";
}

input.check-toggle-round-flat + label:before {
top: 2px;
left: 2px;
bottom: 2px;
right: 2px;
background-color: #d4d7d4; 
border-radius: 60px;
}
input.check-toggle-round-flat + label:after {
top: 4px;
left: 4px;
bottom: 4px;
width: 46px;
background-color: #e31b1b;
-webkit-border-radius: 52px;
-moz-border-radius: 52px;
-ms-border-radius: 52px;
-o-border-radius: 52px;
border-radius: 52px;
-webkit-transition: margin 0.2s;
-moz-transition: margin 0.2s;
-o-transition: margin 0.2s;
transition: margin 0.2s;
}

input.check-toggle-round-flat:checked + label {
}

input.check-toggle-round-flat:checked + label:after {
margin-left: 44px;
background: #46a31d;
}
[type="checkbox"]:not(.filled-in)+label:after {
  border: 0;

  transform: none !important;
}
[type="checkbox"]+label:before, [type="checkbox"]:not(.filled-in)+label:after {
  border:none !important;
}
input.check-toggle-round-flat + label:after {
  top: 3px !important;
  left: 4px !important;
  bottom: 23px !important;
  width: 46px !important;
  height: 25px !important;
  background-color: #e31b1b;
  -webkit-border-radius: 52px;
  -moz-border-radius: 52px;
  -ms-border-radius: 52px;
  -o-border-radius: 52px;
  border-radius: 52px !important;
  -webkit-transition: margin 0.2s;
  -moz-transition: margin 0.2s;
  -o-transition: margin 0.2s;
  transition: margin 0.2s;
}
input.check-toggle-round-flat + label:before {
  top: 2px !important;
  left: 2px !important;
  bottom: 2px;
  right: 2px;
  background-color: #d4d7d4;
  border-radius: 60px;
}
.checkbox-cell {
  text-align: center;
}
[type="checkbox"]:checked, [type="checkbox"]:not(:checked){
  position: relative !important;
opacity: 1 !important;
left: 0px;
transform: scale(1.5); /* Make checkbox larger */
  -webkit-transform: scale(1.5); /* Safari and Chrome */
  -moz-transform: scale(1.5); /* Firefox */
  -o-transform: scale(1.5); /* Opera */
  -ms-transform: scale(1.5); /* IE 9 */

}
.select2-container{
    width:100% !important;
    /* visibility:hidden; */
}
.select2-container.actv{
    /* visibility:visible; */
}

    </style>
<section class="content">

    <div class="row">
      
    <div class="col-12">
       
      <div class="col-12">
        <div class="nav-tabs-custom box-profile">
        <h2 style="
    margin-bottom: 20px;
">Update PLF Profile</h2>
        <ul class="nav nav-tabs">
            <li style="/* border-top-left-radius: 40px; */ border-radius: 40px;">
                <a class="active show" href="#basic_info" data-toggle="tab" style=" border-top-left-radius: 25px;  border-top-right-radius: 25px;">VO Profile Information</a>
            </li>
            <li>
                <a class="" href="#vo_mapping" id="vo_mappings" data-toggle="tab" style=" border-top-right-radius: 25px;">SHG Mapping</a>
            </li>
            <li>
                <a class="" href="#executive_mapping" data-toggle="tab" style=" border-top-right-radius: 25px;">Executive Committee</a>
            </li>
            <li>
                <a class="office_bearerssss" href="#office_bearers" id="office_bearerssss" data-toggle="tab" style=" border-top-right-radius: 25px;">Office Bearers</a>
            </li>
            <li>
                <a class="" href="#bank_account" data-toggle="tab" style=" border-top-right-radius: 25px;">Bank Account</a>
            </li>
            <li>
                <a class="" href="#sub_committees" data-toggle="tab" style=" border-top-right-radius: 25px;">Sub Committees</a>
            </li>
            <li>
                <a class="" href="#bmmu_detail" data-toggle="tab" id="bmmu_detailsss" style=" border-top-right-radius: 25px;">PLF Detail</a>
            </li>
        </ul>
                      
          <div class="tab-content">  
            <div class="{{ old('tab','basic_info') == 'basic_info' ? 'active' : ''}} tab-pane shg_1" id="basic_info">	
                <form  method="post" class="form-horizontal" id="basic_information" enctype="multipart/form-data">
                    @csrf	
                <input type="hidden" name="tab" value="basic_info"> 
                <div class="box p-15"> 
                  <div class="body-data">
                  <section class="VOdetails">
                  <div>
                  </div>
                  <div class="container">
                    
                    <form id="exampleForm">
                  <div class="row">
                  <div class="col-sm-6">
                  <div class="form-group">
                  <label for="Blocknameee">District Name</label>
                  <input type="text" class="form-control" id="Districtname" name="district_name" readonly="" placeholder="District Name" data-label="District Name" value="{{$user_data['dist_name']}}">
                  </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                  <label for="Blocknameee">Block Name</label>
                  <input type="text" class="form-control" id="Blocknameee" name="Block_name" readonly="" placeholder="Block Name" data-label="Block Name" value="{{$user_data['block_name']}}">
                  </div>
                  </div>
                 
                  </div>
                  <div class="row">
                  <div class="col-sm-6">
                        <div class="form-group">
                            <label for="PromotedBy">Panchayat Name</label>
                            <input type="text" class="form-control" id="Panchayatnamee" name="Block_name" readonly="" placeholder="Panchayat Name" data-label="Panchayat Name" value="{{$profile->PanchayatDetails->villagename}}">
                    </div>
                </div>    
                <div class="col-sm-6"><div class="form-group">
                    <label for="VO_id">VO ID</label>
                    <input type="text" class="form-control" id="VO1id" name="VO_id1" placeholder="VO ID" value="{{$profile->vo_id}}" readonly ></div></div>
                    
                  </div>
                  <div class="row">
                
               
                  <div class="col-sm-6">
                    <div class="form-group">
                        <label for="VO_code">VO Code</label>
                        <input type="text" class="form-control" id="VO1code" name="VO_code1" placeholder="Enter VO Code"  readonly data-label="VO Code" value="{{$profile->vo_code}}">
                    </div>
                </div>
                <div class="col-sm-6"><div class="form-group">
                  <label for="vo_name">VO Name</label>
                  <input type="text" class="form-control" id="VO1Name" name="vo_name" placeholder="Enter VO Name" data-label="VO Name" value="{{$profile->vo_name}}" >
                  </div>
                  </div>
                
            </div>
            <div class="row">
           
                    <div class="col-sm-6"><div class="form-group"><label for="Formation_Date">Formation Date</label><input type="date" class="form-control" id="Formation-Date" name="Formation_date" placeholder="Enter Formation Date" data-label="Formation Date" value="{{$profile->fomation_date}}"></div></div>

                     <div class="col-sm-6">
                        <div class="form-group">
                            <label for="PromotedBy">Promoted By</label>
                            <select id="formatted_by" name="promoted_by">

                            <option value="NRLM" @if($profile->promoted_by == "NRLM") selected @endif> NRLM </option>
                            <option value="Non Mathi" @if($profile->promoted_by == "Non Mathi") selected @endif> Non Mathi </option>
                            <option value="Mathi" @if($profile->promoted_by == "Mathi") selected @endif> Mathi </option>
                            <option value="Others" @if($profile->promoted_by == "Others") selected @endif> Others </option>
                        </select>
                    </div>
                </div>    
                    </div>
                    
                    <div class="row">
                   
                    <div class="col-sm-6"><div class="form-group"><label for="LastOfficeBearerElectedDate">Last Office Bearer Elected Date</label><input type="date" class="form-control" id="Last1Office" name="Last__Office" placeholder="Last Office Bearer Elected Date" data-label="Last Office Bearer Elected Date" value="{{$profile->last_office_bearer_elected_date}}"></div></div>
                    <div class="col-sm-6"><div class="form-group"><label for="TenureofOBelection">Tenure of OB election</label><input type="number" class="form-control" id="TenureofOB1election" name="TenureofOB1election" placeholder="Tenure of OB election" data-label="Tenure of OB election" value="{{$profile->ob_election_tenure}}"></div></div>  
                    </div>
                    <div class="row"> 
                    
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label for="role" style="width:100%">Registration of VO</label>
                  <div class="switch4"><input id="is_lawn" class="check-toggle check-toggle-round-flat" type="checkbox" name="is_lawn"> <label for="is_lawn"></label>
                  <span class="on">No</span> 
                  <span class="off">Yes</span>
                  </div>
                </div></div>
                  <div class="col-sm-6 registeration" style="display:none">
                    <div class="form-group">
                        <label for="RegistrationNumber">Registration Number</label>
                        <input type="number" class="form-control" id="Registration1Number" name="Registration__Number" placeholder="Enter Registration Number" data-label="Registration Number" value="{{$profile->register_no}}">
                    </div>
                    </div>  
                  </div>
                  <div class="row registeration" style="display:none">
                 
                  <div class="col-sm-6"><div class="form-group"><label for="RegistrationAct">Registration Act</label>
                  <select id="Registration1Act" name="reg_copy">
                  <option value="Societies Registration Act" @if($profile->register_act == "Societies Registration Act") selected @endif> Societies Registration Act </option>
                  <option value="Others" @if($profile->register_act == "Others") selected @endif> Others </option>  
                </select></div></div>
                  <div class="col-sm-6"><div class="form-group"><label for="RegistrationCopy">Registration Copy</label><input type="file" class="form-control" id="Registration1Copy" name="Registration_ofVO" placeholder="Registration Copy" data-label="Registration Copy" value="{{$profile->registered_copy}}"> 
                </div></div> 
                  </div>
                  <div class="row">
                   
                  <div class="col-sm-6"><div class="form-group"><label for="No.ofVOsUndertheVO">No. of SHGs Under the VO</label><input type="number" class="form-control" id="NoofVOsUndertheVO" name="NoofVOsUndertheVO" placeholder="No. of VOs Under the VO" data-label="No. of VOs Under the VO" value="{{$profile->total_shg}}"></div></div>
                  
                  <div class="col-sm-6"><div class="form-group"><label for="VOActiveStatus">VO Active Status</label>
                  <select id="VOActive" name="VOActive">
                  <option value="Active" @if($profile->status == "Active") selected @endif> Active </option>
                  <option value="Inactive" @if($profile->status == "Inactive") selected @endif> Inactive </option>  
                </select></div></div></div></form></div></section> 
                 
                </div>
                    <div class="form-group">
                        <div class="col-12">
                            <button class="btn btn-primary btn-sm pull-right" id="save" type="button">
                               Save
                            </button>
                        </div>
                    </div>

                    </div>	
            </form>		  
                </div>

            <div class="{{ old('tab') == 'vo_mapping' ? 'active' : ''}} tab-pane shg_mappingss" id="vo_mapping">		
                <div class="box p-15">		
                  <section class="VOdetails"><div class="container"><form id="exampleForm">
                    <div class="row">
                  <div class="col-sm-6">
                        <div class="form-group">
                            <label for="PromotedBy">Panchayat Name</label>
                            <input type="text" class="form-control" id="Panchayatnamee" name="Block_name" readonly="" placeholder="Panchayat Name" data-label="Panchayat Name" value="{{$profile->PanchayatDetails->villagename}}">
                    </div>
                </div>      
                  <div class="col-sm-6"><div class="form-group"><label for="SelectVOName">Select Habitation</label>
                  <select id="habitation"  name="promoted_by"> 
                        <option value="" selected disabled> Select Habitation </option>
                        @foreach($habitation as $k=>$v)
                        <option value="{{$v->id}}"> {{$v->habitation}} </option>
                        @endforeach
                        <option >
                        </select>  
                </div></div>
            
            </div>
                <div class="row">
                    <div class="tab-containers">
    <div class="tabss">
        <div class="tab1 active unmapping" data-val="unmap" onclick="openTab(event, 'mapped')">UnMapped SHG Details</div>
        <div class="tab1 mapping" data-val="map" onclick="openTab(event, 'unmapped')">Mapped SHG Details</div>
    </div>

    <div id="mapped" class="tab-content1 active">
    <div class="mapped-container">
    <div class="mapped-title">UnMapped SHG Details
                        <button class="map-button" style="display:none;" data-val="map" type="button">Map SHG</button>
                    </div>
                    <div class="search-container">
                        <input type="text" id="search" placeholder="Search...">
                        <label>
                            <input type="checkbox" id="select-all">
                            Select All
                        </label>
                    </div>
                    <div class="table-container">
                        <table id="shg-table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all-rows"></th>
                                    <th>SHG Name</th>
                                    <th>Formation Date</th>
                                </tr>
                            </thead>
                            <tbody id="mapped_list">
                            </tbody>
                        </table>
                    </div>

        </div>
    </div>

    <div id="unmapped" class="tab-content1">
    <div class="mapped-container1">
    <div class="mapped-title">Mapped SHG Details
                        <button class="map-button" style="display:none;" data-val="unmap" type="button">UnMap SHG</button>
                    </div>
                    <div class="search-container">
                        <input type="text" id="search" placeholder="Search...">
                        <label>
                            <input type="checkbox" id="select-all">
                            Select All
                        </label>
                    </div>
                    <div class="table-container">
                        <table id="shg-table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all-rows"></th>
                                    <th>SHG Name</th>
                                    <th>Formation Date</th>
                                </tr>
                            </thead>
                            <tbody id="mapped_list1">
                            </tbody>
                        </table>
                    </div>

        </div>
    </div>
</div>

                <!-- <div class="col-sm-6"><div class="form-group"><label for="SelectVOName">Select SHG Name</label>
                  <select id="VOActive" name="promoted_by"> 
                        <option value=""> Select SHG Name </option>
                        <option value="Chekankadu" > SHG Data </option> SHG Data </option>
                        <option value="Vennila Group" > Vennila Group </option>
                        </select>  
                </div></div>
                    <div class="col-sm-6"><div class="form-group"><label for="VOJoiningDate">VO Joining Date</label><input type="date" class="form-control" id="VO-JoiningDate" name="VO-JoiningDate" placeholder="VO Joining Date" data-label="VO Joining Date"></div></div> -->
                     
                </div>
                     
                  <div class="form-group">
                        <div class="col-12">
                            <button class="btn btn-primary btn-sm pull-right" type="submit">
                               Save
                            </button>
                        </div>
                    </div>
                </form></div></section>
                </div>			  
            </div>
            <div class="{{ old('tab') == 'executive_mapping' ? 'active' : ''}} tab-pane executive_mapping" id="executive_mapping">		
                <div class="box p-15">		
                  <section class="VOdetails"><div class="container">
                    <form id="exampleForm3">
                        <input type="hidden" value="{{$profile->id}}" id="plf_id">
                    <button class="btn btn-primary btn-sm pull-right submit-ec2" type="button">
                               Show Executive Comittee
                            </button>
                    <div id="ec-sections">
                    <div class="ec-section">
                    <h4 class="section-header">Executive Committee <span class="serial-no">1</span></h4>
                  <div class="row">
                  <div class="col-sm-6">
                        <div class="form-group">
                            <label for="PromotedBy">Panchayat Name</label>
                            <input type="text" class="form-control" id="Panchayatnamee" name="Block_name" readonly="" placeholder="Panchayat Name" data-label="Panchayat Name" value="{{$profile->PanchayatDetails->villagename}}">
                    </div>
                </div>      
                  <div class="col-sm-6"><div class="form-group"><label for="SelectVOName">Select Habitation</label>
                  <select id="habitation1" class="habitation" name="ec[0][habitation1]" index="0"> 
                        <option value="" selected disabled> Select Habitation </option>
                        @foreach($habitation as $k=>$v)
                        <option value="{{$v->id}}"> {{$v->habitation}} </option>
                        @endforeach
                        <option >
                        </select>  
                </div></div>
            
            </div>
                    <div class="row fetch_shg_group" >
                    <div class="col-sm-6">
   <div class="form-group">
   <label for="SelectVOName">Select SHG</label>
                  <select id="shg_group" class="shg_group_0 shg_group" index="0" name="ec[0][shg_group]">
                    
                  </select>  
                </div></div><div class="col-sm-6">
                        <div class="form-group">
                        <label for="SelectVOName">Select SHG Member Name</label>
                            <select id="shg_member" class="shg_member_0 shg_member"name="ec[0][shg_member]"><option value="" selected="" disabled=""> Select SHG Member Name </option></select>  
                    </div></div>
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-6"><div class="form-group"><label for="FromDate">From Date</label><input type="date" class="form-control" id="From-Date11" name="ec[0][frmdate]" placeholder=" " data-label=" From Date"></div></div>
                        <div class="col-sm-6"><div class="form-group"><label for="TO-Date">TO Date</label><input type="date" class="form-control" id="TO-Date111" name="ec[0][todate]" placeholder="TO Date" data-label=" TO Date"></div></div>
                    </div>
                    </div>
                    </div>
                  <div class="form-group">
                        <div class="col-12">
                       
                            <button class="btn btn-primary btn-sm pull-right submit-ec" type="button">
                               Save
                            </button>
                            <button type="button" id="add-section" class="btn btn-secondary btn-sm pull-right">Add +</button>
                        </div>
                    </div>
                </form></div>
               
            </section>
                </div>			  
            </div>


            <div class="{{ old('tab') == 'office_bearers' ? 'active' : ''}} tab-pane office_bearers" id="office_bearers">		
                <div class="box p-15">		
                   <section class="VOdetails"><div>
                    <!-- <h4> <b> Office Bearers </b></h4> -->
                </div><div class="container"><form id="exampleForm4">
                <!-- <h4 style="
                    font-size: 20px;
                    font-weight: 600;
                    color: #0a7e8c;
                ">President</h4>     -->
                <div class="row">
                    <input type="hidden" name="plf_id" value="{{$profile->id}}">
                    <div class="col-sm-6"><div class="form-group"><label for="SelectVOName">Select Role</label>
                  <select id="president" class="president select_ec" name="president">  
                  <option value="" selected disabled> President </option>  
                        <option >
                        </select>  
                </div></div>
</div>
                <div class="row">
                    <input type="hidden" name="plf_id" value="{{$profile->id}}"> 
                <div class="col-sm-6"><div class="form-group"><label for="SelectVOName">Select President</label>
                  <select id="president" class="president select_ec" name="president">  
                  <option value="" selected disabled> Select President </option>
                        @foreach($ec as $k=>$v)
                        <option value="{{$v->id}}"> {{$v->shg_member_name}} </option>
                        @endforeach
                        <option >
                        </select>  
                </div></div>
                
                <div class="col-sm-6"><div class="form-group"><label for="FromDate">From Date</label><input type="date" class="form-control" id="From-Date5656" name="president_from_date" placeholder=" " data-label="From Date"></div></div>
            </div>
                
                <div class="row">
                   
                    
                    <div class="col-sm-6"><div class="form-group"><label for="TODate">TO Date</label><input type="date" class="form-control" id="TO-Date5" name="president_to_date" placeholder=" " data-label="TO Date"></div></div>

                    <div class="col-sm-6"><div class="form-group"><label>Signatory</label><div class="form-check">
                        <input type="radio" class="form-check-input" id="SignatoryYes" name="Signatory" data-label="Signatory " value="Yes">
                        <label class="form-check-label" for="SignatoryYes">Yes</label>
                    </div><div class="form-check ">
                        <input type="radio" class="form-check-input" id="SignatoryNo" name="Signatory" data-label="Signatory " value="No">
                        <label class="form-check-label" for="SignatoryNo">No</label></div></div></div>
                </div>
                     <!-- <h4 style="
                    font-size: 20px;
                    font-weight: 600;
                    color: #0a7e8c;
                ">Secretary</h4>    
               <div class="row">
                <div class="col-sm-6"><div class="form-group"><label for="SelectVOName">Select Secretary</label>
                  <select id="president" class="president select_ec" name="secretary">  
                  <option value="" selected disabled> Select Secretary </option>
                        @foreach($ec as $k=>$v)
                        <option value="{{$v->id}}"> {{$v->shg_member_name}} </option>
                        @endforeach
                        <option >
                        </select>  
                </div></div>
                
                <div class="col-sm-6"><div class="form-group"><label for="FromDate">From Date</label><input type="date" class="form-control" id="From-Date5656" name="secretary_from_date" placeholder=" " data-label="From Date"></div></div>
            </div>
                
                <div class="row">
                   
                    
                    <div class="col-sm-6"><div class="form-group"><label for="TODate">TO Date</label><input type="date" class="form-control" id="TO-Date5" name="secretary_to_date" placeholder=" " data-label="TO Date"></div></div>

                    <div class="col-sm-6"><div class="form-group"><label>Signatory</label><div class="form-check"><input type="radio" class="form-check-input" id="SignatoryYes1" name="secretary_signatory" data-label="Signatory " value="Yes"><label class="form-check-label" for="SignatoryYes1">Yes</label></div><div class="form-check "><input type="radio" class="form-check-input" id="SignatoryNo1" name="secretary_signatory" data-label="Signatory " value="No"><label class="form-check-label" for="SignatoryNo1">No</label></div></div></div>
                </div>

                <h4 style="
                    font-size: 20px;
                    font-weight: 600;
                    color: #0a7e8c;
                ">Treasurer</h4>    
               <div class="row">
                <div class="col-sm-6"><div class="form-group"><label for="SelectVOName">Select Treasurer</label>
                  <select id="treasure" class="president select_ec" name="treasure">  
                  <option value="" selected disabled> Select Treasurer </option>
                        @foreach($ec as $k=>$v)
                        <option value="{{$v->id}}"> {{$v->shg_member_name}} </option>
                        @endforeach
                        <option >
                        </select>  
                </div></div>
                
                <div class="col-sm-6"><div class="form-group"><label for="FromDate">From Date</label><input type="date" class="form-control" id="From-Date5656" name="treasure_from_date" placeholder=" " data-label="From Date"></div></div>
            </div>
                
                <div class="row">
                   
                    
                    <div class="col-sm-6"><div class="form-group"><label for="TODate">TO Date</label><input type="date" class="form-control" id="TO-Date5" name="treasure_to_date" placeholder=" " data-label="TO Date"></div></div>

                    <div class="col-sm-6"><div class="form-group"><label>Signatory</label><div class="form-check"><input type="radio" class="form-check-input" id="SignatoryYes2" name="treasure_signatory" data-label="Signatory " value="Yes"><label class="form-check-label" for="SignatoryYes2">Yes</label></div><div class="form-check "><input type="radio" class="form-check-input" id="SignatoryNo2" name="treasure_signatory" data-label="Signatory " value="No"><label class="form-check-label" for="SignatoryNo2">No</label></div></div></div>
                </div>
                
                <h4 style="
                    font-size: 20px;
                    font-weight: 600;
                    color: #0a7e8c;
                ">Book Keeper</h4>    
               <div class="row">
                <div class="col-sm-6"><div class="form-group"><label for="SelectVOName">Select Book Keeper</label>
                  <select id="president" class="president select_ec" name="bookkeeper">  
                  <option value="" selected disabled> Select Book Keeper </option>
                        @foreach($ec as $k=>$v)
                        <option value="{{$v->id}}"> {{$v->shg_member_name}} </option>
                        @endforeach
                        <option >
                        </select>  
                </div></div>
                
                <div class="col-sm-6"><div class="form-group"><label for="FromDate">From Date</label><input type="date" class="form-control" id="From-Date5656" name="bookkeeper_from_date" placeholder=" " data-label="From Date"></div></div>
            </div>
                
                <div class="row">
                   
                    
                    <div class="col-sm-6"><div class="form-group"><label for="TODate">TO Date</label><input type="date" class="form-control" id="TO-Date5" name="bookkeeper_to_date" placeholder=" " data-label="TO Date"></div></div>

                    <div class="col-sm-6"><div class="form-group"><label>Signatory</label><div class="form-check"><input type="radio" class="form-check-input" id="SignatoryYes3" name="bookkeeper_signatory" data-label="Signatory " value="Yes"><label class="form-check-label" for="SignatoryYes3">Yes</label></div><div class="form-check "><input type="radio" class="form-check-input" id="SignatoryNo3" name="bookkeeper_signatory" data-label="Signatory " value="No"><label class="form-check-label" for="SignatoryNo3">No</label></div></div></div>
                </div> -->
                
                <div class="form-group">
                        <div class="col-12">
                            <button class="btn btn-primary btn-sm pull-right save-office" type="button">
                            Save
                            </button>
                        </div>
                    </div>
</form></div></section>
                </div>			  
            </div>


            <div class="{{ old('tab') == 'bank_account' ? 'active' : ''}} tab-pane" id="bank_account">		
                <div class="box p-15">		
                <section class="VOdetails"><div>
                     
                     </div><div class="container"><form id="exampleForm">
                      <div class="form-group">
                        <div class="col-12">
                          
                            <button type="button" id="add-section1" class="btn btn-secondary btn-sm pull-right">Add +</button>
                        </div>
                    </div>
                     <div id="bank-account-details">
                     <div class="account-name">
                     <h4 class="section-header">Bank Account <span class="serial-no1">1</span></h4>
                     <div class="row bank_ifsc">
                        <div class="col-sm-6"><div class="form-group">
                        <label for="VONameasperPassbook">VO Name as per Passbook</label>
                        <input type="text" class="form-control" id="VONameasperPassbook" name="bankaccount[0][VONameasperPassbook]" placeholder="VO Name as per Passbook" data-label="VO Name as per Passbook" value=" ">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="IFSC">IFSC</label>
                    <input type="text" class="form-control ifsc-input" id="IFSC11" name="bankaccount[0][IFSC11]" placeholder="IFSC" data-label="IFSC" maxlength="11" >
                    </div>
                </div>
                <div class="col-sm-3" style="
                    position: relative;
                    top: 30px;
                ">
                    <div class="form-group"> 
                        <button style="padding:6px" class="btn btn-primary btn-sm fetchbank" id="fetchbank" type="button" disabled>
                            Fetch Bank Details
                            </button>
                    </div>
                </div>
                      
                    </div> 
                    <div class="row"><div class="col-sm-6">
                        <div class="form-group ">
                            <label for="Bank_Name">Bank Name</label>
                            <input type="text" class="form-control" id="BankName" name="bankaccount[0][BankName]" placeholder="Bank Name" data-label="Bank Name" disabled>
                            <div class="select2-container1" style="display:none">
                            <select id="banks_0"  name="bankaccount[0][BankName]" class="banks" > 
                        <option value="" selected disabled> Select Bank Name </option>
                        @foreach($bank_names as $k=>$v)
                        <option value="{{$v->id}}"> {{$v->bank_name}} </option>
                        @endforeach
                        <option >
                        </select>  
                        </div>
                        </div>
                       
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="BranchName">Branch Name</label>
                            <input type="text" class="form-control" id="BranchName" name="bankaccount[0][BranchName]" placeholder="Branch Name" data-label="Branch Name" disabled>
                            <div class="select2-container2" style="display:none">
                            <select id="branches_0"  name="bankaccount[0][BranchName]" > 
                        <option value="" selected disabled> Select Branch Name </option>
                     
                        <option >
                        </select>  
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="AccountNumber">Account Number </label>
                            <input type="number" class="form-control" id="AccountNumber" name="bankaccount[0][AccountNumber]" placeholder="Account Number " data-label="Account Number ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="RetypeAccNo">Retype Acc No</label>
                            <input type="number" class="form-control" id="RetypeAccNo" name="bankaccount[0][RetypeAccNo]" placeholder="Retype Acc No" data-label="Retype Acc No">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group"><label for="AccountType">Account Type </label>
                        <select id="AccountType" class="president AccountType" name="bankaccount[0][AccountType]">  
                            <option value="" selected disabled> Select Account Type </option>  
                        <option value="Gen">Gen</option>
                        <option value="CIF">CIF</option>
                        <option value="LH">LH </option>
                        <option value="ASF">ASF</option>
                        <option value="VPRC">VPRC</option>
                        <option value="CMBFS">CMBFS</option>
                        <option value="Others">Others</option>
                        </select>      
                    </div></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="Account Opening Date">Account Opening Date</label>
                            <input type="date" class="form-control" id="AccountOpeningDate" name="bankaccount[0][AccountOpeningDate]" placeholder="Account Opening Date" data-label="Account Opening Date">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="PassbookPageUpload">Passbook Page Upload</label>
                            <input type="file" class="form-control" id="PassbookPageUpload" name="bankaccount[0][PassbookPageUpload]" placeholder="Passbook Page Upload  " data-label="Passbook Page Upload  ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Is Primary Account</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="IsPrimaryAccountYes" name="bankaccount[0][IsPrimaryAccount]" data-label="RIs Primary Account" value="Yes">
                    <label class="form-check-label" for="IsPrimaryAccountYes">Yes</label>
                    </div>
                    <div class="form-check ">
                        <input type="radio" class="form-check-input" id="IsPrimaryAccountNo" name="bankaccount[0][IsPrimaryAccount]" data-label="Is Primary Account" value="No">
                        <label class="form-check-label" for="IsPrimaryAccountNo">No</label>
                    </div></div></div></div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Status</label>
                                <div class="form-check">
                                <input type="radio" class="form-check-input" id="StatusYes11" name="bankaccount[0][IsPrimaryAccount]" data-label="Status" value="Yes">
                                <label class="form-check-label" for="Status11Yes">Yes</label>
                            </div>
                            <div class="form-check ">
                                <input type="radio" class="form-check-input" id="StatusNo11" name="bankaccount[0][IsPrimaryAccount]" data-label="Status" value="No">
                                <label class="form-check-label" for="IsPrimaryAccountNo">No</label>
                            </div></div>
                        </div>
                    </div>
                    </div>
                    </div>
                    <div class="form-group">
                        <div class="col-12">
                            <button class="btn btn-primary btn-sm pull-right" type="submit">
                            Save
                            </button> 
                        </div>
                    </div>
                    </form>
                    </div>
                    </section>
                </div>			  
            </div>



            <div class="{{ old('tab') == 'sub_committees' ? 'active' : ''}} tab-pane" id="sub_committees">		
                <div class="box p-15">		
                   <section class="VOdetails"><div><h4> <b> Sub Committees </b></h4></div><div class="container"><form id="exampleForm"><div class="row"><div class="col-sm-6"><div class="form-group"><label for="SubCommitteeName">Sub Committee Name</label><input type="text" class="form-control" id="SubCommitteeName" name="SubCommitteeName" placeholder="Sub Committee Name" data-label="Sub Committee Name" value=" "></div></div><div class="col-sm-6"><div class="form-group"><label for="FormationDate">Formation Date</label><input type="date" class="form-control" id="FormationDate1" name="FormationDate1" placeholder="Formation Date" data-label="Formation Date"></div></div></div><div class="row"><div class="col-sm-6"><div class="form-group"><label for="MemberDetail">Member Detail</label><input type="number" class="form-control" id="Member1Detail1" name="MemberDetail1" placeholder="Member Detail" data-label="Member Detail"></div></div><div class="col-sm-6"><div class="form-group"><label for="DateofJoined ">Date of Joined </label><input type="date" class="form-control" id="Date1of1Joined" name="Date1ofJoined " placeholder="Date of Joined " data-label="Date of Joined "></div></div></div><div class="row"><div class="col-sm-6"><div class="form-group"><label for="Address&amp;ContactDetails ">Address &amp; Contact Details </label><input type="text" class="form-control" id="Address&amp;ContactDetails " name="Address&amp;Contact Details " placeholder="Address &amp; Contact Details " data-label="Address &amp; Contact Details "></div></div><div class="col-sm-6"><div class="form-group"><label for="Select GP ">Select GP </label><input type="text" class="form-control" id="SelectGP" name="SelectGP" placeholder="Select GP" data-label="Select GP"></div></div></div><div class="row"><div class="col-sm-6"><div class="form-group"><label for="AddressoftheBlockOffice">Address of the Block Office</label><input type="text" class="form-control" id="AddressoftheBlockOffice" name="AddressoftheBlockOffice" placeholder=" Address of the Block Office" data-label="Address of the Block Office"></div></div><div class="col-sm-6"><div class="form-group"><label for="Pincode">Pincode</label><input type="number" class="form-control" id="Pincode111" name="Pincode111" placeholder="Pincode" data-label="Pincode"></div></div></div><div class="row"><div class="col-sm-6"><div class="form-group"><label for="LatLongoftheBlockOffice ">Lat Long of the Block Office </label><input type="text" class="form-control" id="LatLongoftheBlockOffice" name="LatLongoftheBlockOffice" placeholder="Lat Long of the Block Office " data-label="Lat Long of the Block Office "></div></div><div class="col-sm-6"><div class="form-group"><label for="PhotooftheBlockOffice">Photo of the Block Office </label><input type="text" class="form-control" id="PhotooftheBlockOffice" name="PhotooftheBlockOffice" placeholder="Photo of the Block Office " data-label="Photo of the Block Office "></div></div></div><div class="row"><div class="col-sm-6"><div class="form-group"><label for="PresidentName">President Name</label><input type="text" class="form-control" id="PresidentName11" name="PresidentName11" placeholder="President Name" data-label="President Name"></div></div><div class="col-sm-6"><div class="form-group"><label for="ContactNumber">Contact Number</label><input type="number" class="form-control" id="ContactNumber1" name="ContactNumber1" placeholder="Contact Number" data-label="Contact Number"></div></div></div><div class="row"><div class="col-sm-6"><div class="form-group"><label for="Secretary Name">Secretary Name</label><input type="text" class="form-control" id="SecretaryName11" name="SecretaryName11" placeholder="Secretary Name" data-label="Secretary Name"></div></div><div class="col-sm-6"><div class="form-group"><label for="ContactNumber">Contact Number</label><input type="number" class="form-control" id="ContactNumber111" name="ContactNumber111" placeholder="Contact Number" data-label="Contact Number"></div></div></div><div class="row"><div class="col-sm-6"><div class="form-group"><label for="TreasurerName">Treasurer Name </label><input type="text" class="form-control" id="Treasurer11Name" name="Treasurer11Name" placeholder="Treasurer Name" data-label="Treasurer Name"></div></div><div class="col-sm-6"><div class="form-group"><label for="ContactNumber">Contact Number</label><input type="number" class="form-control" id="ContactNumber1111" name="ContactNumber1111" placeholder="Contact Number" data-label="Contact Number"></div></div></div>
                   <div class="form-group">
                        <div class="col-12">
                            <button class="btn btn-primary btn-sm pull-right" type="submit">
                            Save
                            </button>
                        </div>
                    </div>
                    </form></div></section>

                </div>			  
            </div>


            <div class="{{ old('tab') == 'bmmu_detail' ? 'active' : ''}} tab-pane bmmu_detail" id="bmmu_detail">		
                <div class="box p-15">		
                  <section class="VOdetails"><div class="container"><form id="exampleForm5"><div class="row">
                  <input type="hidden" value="{{$profile->id}}" id="plf_id">
                  <div class="col-sm-6">
                        <div class="form-group">
                            <label for="PromotedBy">Panchayat Name</label>
                            <input type="text" class="form-control" id="Panchayatnamee" name="Block_name" readonly="" placeholder="Panchayat Name" data-label="Panchayat Name" value="{{$profile->PanchayatDetails->villagename}}">
                    </div>
                </div>        
                  <div class="col-sm-6">
                    <div class="form-group">
                        <label for="BMMUDetails ">Address of the VO Office </label>
                        <textarea type="text" class="form-control" id="address" name="address" placeholder="BMMU Details " data-label="BMMU Details " value="{{$profile->address}}"> 
                        </textarea>
                    </div>
                    </div>
                   
                </div>
                <div class="row">
                <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pincode">Pincode </label>
                            @if($profile->pincode != NULL) 
                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode " data-label="pincode" value="{{$profile->pincode}}">
                            @else
                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode " data-label="pincode">
                            @endif
                          
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pincode">latitude </label>
                            @if($profile->latitude != NULL)
                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter latitude " data-label="latitude" value="{{$profile->latitude}}">
                            @else
                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter latitude " data-label="latitude">
                            @endif
                           
                        </div>
                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pincode">Longitude </label>
                            @if($profile->logitude != NULL)
                            <input type="text" class="form-control" id="logitude" name="logitude" placeholder="Enter logitude " data-label="logitude" value="{{$profile->logitude}}"> 
                            @else
                            <input type="text" class="form-control" id="logitude" name="logitude" placeholder="Enter logitude " data-label="logitude">
                            @endif
                          
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="photo">Photo Of the VO Office </label>
                            <input type="file" class="form-control" id="photo" name="photo" placeholder="Enter logitude " data-label="photo">
                        </div>
                    </div>
                    </div>
                    <div class="row">
               <div class="col-sm-6">
                <div class="form-group">
                    <label>Whether VO have internet connectivity ? </label>
                    <div class="form-check">
                    <input type="radio" id="internetYes" name="internet" value="Yes">
                    <label for="internetYes">Yes</label><br>
                    </div>
                    <div class="form-check ">
                    <input type="radio" id="internetNo" name="internet" value="No">
                    <label for="internetNo">No</label>
                    </div>
                </div>
                </div>
                <div id="internetProviderDiv" class="hidden col-sm-6" >
                        <div class="form-group">
                            <label for="service_provider_name">Select Internet Service Provider:</label>
                            <select id="service_provider_name" name="service_provider_name">
                            <option value="" selected disabled>Select Internet Service Provider</option>
                            <option value="Bharat Net" @if($profile->service_provider_name == "Bharat Net") selected @endif> Bharat Net </option>
                            <option value="Fibernet" @if($profile->promoted_by == "Fibernet") selected @endif> Fibernet </option>
                            <option value="ACT" @if($profile->promoted_by == "ACT") selected @endif> ACT </option>
                            <option value="Airtel" @if($profile->promoted_by == "Airtel") selected @endif> Airtel  </option>
                            <option value="Hathway" @if($profile->promoted_by == "Hathway") selected @endif> Hathway   </option>
                            <option value="Hotspot" @if($profile->promoted_by == "Hotspot") selected @endif> Hotspot  </option>
                        </select>
                    </div>
                </div>    
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Whether VO have Computer?</label>
                            <div class="form-check ">
                            <input type="radio" id="computerYes" name="computer" value="Yes">
        <label for="computerYes">Yes</label><br>
        </div>
        <div class="form-check ">
        <input type="radio" id="computerNo" name="computer" value="No">
        <label for="computerNo">No</label>
                        </div>
                        </div>
                        </div>
                   
                   
                    <div class="col-sm-6">
                         <!-- Computer Details -->
                        <div id="computerDetailsDiv" class="hidden">
                            <label>Specify the number of devices:</label><br>
                            <input type="checkbox" id="desktop" name="Desktop" value="1">
                            <label for="desktop">Desktop (Number):</label>
                            <input type="number" id="desktopNumber" name="desktopNumber" min="0"><br>
                            
                            <input type="checkbox" id="laptop" name="Laptop" value="1">
                            <label for="laptop">Laptop (Number):</label>
                            <input type="number" id="laptopNumber" name="laptopNumber" min="0"><br>

                            <input type="checkbox" id="printer" name="Printer" value="Printer">
                            <label for="printer">Printer (Number):</label>
                            <input type="number" id="printerNumber" name="printerNumber" min="0"><br>

                            <input type="checkbox" id="scanner" name="Scanner" value="Scanner">
                            <label for="scanner">Scanner (Number):</label>
                            <input type="number" id="scannerNumber" name="scannerNumber" min="0">
                        </div>
                        </div>
                        </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="WhetherBlockhavePanTanDetails ">Whether Block have Pan / Tan Details </label>
                            @if($profile->BlockhavePanTanDetails != NULL)
                            <input type="text" class="form-control" id="BlockhavePanTanDetails " name="BlockhavePanTanDetails" placeholder=" Enter the Pan / Tan details" data-label="Whether Block have Pan / Tan Details " value="{{$profile->BlockhavePanTanDetails}}">
                            @else
                            <input type="text" class="form-control" id="BlockhavePanTanDetails " name="BlockhavePanTanDetails" placeholder=" Enter the Pan / Tan details" data-label="Whether Block have Pan / Tan Details ">
                            @endif
                          
                        </div>
                    </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-sm-6"><div class="form-group"><label for="BMMName">BMM Name</label><input type="text" class="form-control" id="BMM1Name1" name="BMMName11" placeholder="BMM Name" data-label="BMM Name"></div></div><div class="col-sm-6"><div class="form-group"><label for="ContactNumber ">Contact Number </label><input type="number" class="form-control" id="ContactNumberrfsf " name="ContactNumberfref " placeholder="Contact Number " data-label="Contact Number "></div></div></div>
                        <div class="row"><div class="col-sm-6"><div class="form-group"><label for="BCMISName">BC MIS Name</label><input type="text" class="form-control" id="BCMISName1" name="BCMISName1" placeholder="BC MIS Name " data-label="BC MIS Name"></div></div><div class="col-sm-6"><div class="form-group"><label for="ContactNumber ">Contact Number </label><input type="number" class="form-control" id="ContactNumberrfsfdd " name="ContactNumberfrefdd" placeholder="Contact Number " data-label="Contact Number "></div></div></div>
                        <div class="row"><div class="col-sm-6"><div class="form-group"><label for="BCIBCBName">BC IBCB Name</label><input type="text" class="form-control" id="BCIBCBName" name="BCIBCBName" placeholder="BC IBCB Name" data-label="BC IBCB Name"></div></div><div class="col-sm-6"><div class="form-group"><label for="ContactNumber ">Contact Number </label><input type="number" class="form-control" id="ContactNumberrfsfddd" name="ContactNumberfrefddd" placeholder="Contact Number " data-label="Contact Number "></div></div></div>
                        <div class="row"><div class="col-sm-6"><div class="form-group"><label for="Secretary Name">Secretary Name</label><input type="text" class="form-control" id="SecretaryName11" name="SecretaryName11" placeholder="Secretary Name" data-label="Secretary Name"></div></div><div class="col-sm-6"><div class="form-group"><label for="ContactNumber">Contact Number</label><input type="number" class="form-control" id="ContactNumber111" name="ContactNumber111" placeholder="Contact Number" data-label="Contact Number"></div></div></div>
                        <div class="row"><div class="col-sm-6"><div class="form-group"><label for="TreasurerName">Treasurer Name </label><input type="text" class="form-control" id="Treasurer11Name" name="Treasurer11Name" placeholder="Treasurer Name" data-label="Treasurer Name"></div></div><div class="col-sm-6"><div class="form-group"><label for="ContactNumber">Contact Number</label><input type="number" class="form-control" id="ContactNumber1111" name="ContactNumber1111" placeholder="Contact Number" data-label="Contact Number"></div></div></div> -->

                        <div class="form-group">
                        <div class="col-12">
                            <button class="btn btn-primary btn-sm pull-right save-bmmu" type="button">
                            Submit
                            </button>
                        </div>
                    </div>
                    </form></div></section>

                </div>			  
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
        
    </div>
    <!-- /.row -->

  </section>

  <script>
var currentDate;
    $("#is_lawn").change(function(){ 
        if($(this).is(':checked'))
        {
            $(".registeration").show();
        }
        else{
            $(".registeration").hide();
        }
    })
    $(document).ready(function(){
         let sectionIndex = 1;

    // $('#add-section1').on('click', function () {
    //     sectionIndex++;
    //     let newSection = `
    //     <div class="account-name">
    //         <h4 class="section-header">Bank Account <span class="serial-no1">${sectionIndex}</span></h4>
    //         <div class="row">
    //             <div class="col-sm-6">
    //                 <div class="form-group">
    //                     <label for="VONameasperPassbook">VO Name as per Passbook</label>
    //                     <input type="text" class="form-control" id="VONameasperPassbook${sectionIndex}" name="bankaccount[${sectionIndex}][VONameasperPassbook]" placeholder="VO Name as per Passbook">
    //                 </div>
    //             </div>
    //             <div class="col-sm-3">
    //                 <div class="form-group">
    //                     <label for="IFSC">IFSC</label>
    //                     <input type="text" class="form-control" id="IFSC${sectionIndex}" name="bankaccount[${sectionIndex}][IFSC]" placeholder="IFSC" maxlength="11" oninput="checkIFSCLength()">
    //                 </div>
    //             </div>
    //             <div class="col-sm-3" style="position: relative; top: 30px;">
    //                 <div class="form-group"> 
    //                     <button style="padding:6px" class="btn btn-primary btn-sm" id="fetchbank${sectionIndex}" type="button">Fetch Bank Details</button>
    //                 </div>
    //             </div>
    //         </div>
    //         <!-- Continue with the rest of the form fields -->
    //     </div>
    //     `;
    //     $('#bank-account-details').append(newSection);
        
    //     // Reinitialize Select2 for newly added selects
    //     $(`#banks${sectionIndex}`).select2();
    //     $(`#branches${sectionIndex}`).select2();
    // });
    
    // Initialize Select2 for existing selects
    $('#banks_0').select2();
    $('#branches_0').select2();
        // $('#banks').select2({
        //         placeholder: 'Select a Bank Name',
        //         allowClear: true  // Allow clear functionality
        //     });
        //     $('#branches').select2({
        //         placeholder: 'Select a Branch Name',
        //         allowClear: true  // Allow clear functionality
        //     });
               // Handle bank selection change
               $('#branches').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                // Access the data-val attribute of the selected option
                var ifscCode = selectedOption.data('val');
                // alert(ifscCode);
                $("#IFSC11").val(ifscCode);
               });
    $('#banks').on('change', function() {
        // alert("dfgdgdfgdfgdgdgdfgf");
        var bankId = $(this).val();
        if (bankId) {
            // Enable the branches dropdown
            $('#branches').prop('disabled', false);

            // Clear any existing options
            $('#branches').empty().append('<option value="" selected disabled>Select Branch Name</option>');

            // AJAX request to fetch branches based on selected bank
            $.ajax({
                url: '{{url("/")}}/plf-profile/get-branches/' + bankId, // Replace with your actual route
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    // Assuming response is an array of branches
                    $.each(response.bank_details, function(key, value) {
                        $('#branches').append('<option value="' + value.id + '" data-val="'+value.ifsc_code+'">' + value.branch_name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error('Error fetching branches:', xhr);
                }
            });
        } else {
            // If no bank is selected, disable and clear the branches dropdown
            $('#branches').prop('disabled', true).empty().append('<option value="" selected disabled>Select Branch Name</option>');
        }
    }); 
                // Show/Hide Internet Provider dropdown
                $('input[name="internet"]').on('change', function() {
            if ($('#internetYes').is(':checked')) {
                $('#internetProviderDiv').removeClass('hidden');
            } else {
                $('#internetProviderDiv').addClass('hidden');
            }
        });

        // Show/Hide Computer Details
        $('input[name="computer"]').on('change', function() {
            if ($('#computerYes').is(':checked')) {
                $('#computerDetailsDiv').removeClass('hidden');
            } else {
                $('#computerDetailsDiv').addClass('hidden');
            }
        });

        var currentDateIST = new Date().toLocaleString('en-US', { timeZone: 'Asia/Kolkata' });
        console.log('Current IST Date: ' + currentDateIST);

        // Create a new Date object using the IST date string
            currentDate = new Date(currentDateIST);
        console.log('Current Date Object: ' + currentDate);

        // Extract date components
        var year = currentDate.getFullYear();
        var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
        var day = currentDate.getDate().toString().padStart(2, '0');

        // Format date as YYYY-MM-DD
        var currentDateFormatted = year + '-' + month + '-' + day;
        console.log('Formatted Current Date: ' + currentDateFormatted);

        // Set min attribute of date inputs to current date in IST
        $('#Formation-Date').attr('max', currentDateFormatted);
        $('#Last1Office').attr('max', currentDateFormatted);
        $('#From-Date11').attr('max', currentDateFormatted);
        $('#TO-Date111').attr('max', currentDateFormatted);
        
    })
    $("#save").click(function(e){
        e.preventDefault();
        var form_data = new FormData($("#basic_information")[0]);
        var get_vo_name = $("#VO1Name").val();
        var formation_date = $("#Formation-Date").val();
        var LastOffice = $("#Last1Office").val();
        // var LastOffice = $("#Last1Office").val();
        if(get_vo_name == "" || formation_date == "")
        {
        $.toast({
                                heading: '',
                                text: "Please fill out the Basic details",
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 5000,
                                stack: 1
                            });
        }
        else{
            $.ajax({
                    url: '{{url('/')}}/plf-profile/stage/{{$profile->id}}/1',
                    cache: false,
                    method:'post', 
                    dataType:'json',
                    data:form_data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        $.toast({
                                heading: '',
                                text: "Updated Successfully",
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 1000,
                                stack: 1
                            });
                            setTimeout(() => {
                                $("ul.nav-tabs li a").removeClass("active");
                                $("ul.nav-tabs li a#vo_mappings").addClass("active");
                                $(".shg_1").removeClass("active");
                                $(".shg_mappingss").addClass("active");
                                window.scrollTo({
                                    top: 0,
                                    behavior: 'smooth' // Optional: 'smooth' or 'auto'
                                    });
                            }, 1500); // 2000 milliseconds = 2 seconds
                        // console.log(res);
                        // window.location.reload();
                      
                    }
                });
        }
         
    })
    function habitation(tab){
        var data_val = {
        data: $("#habitation").val()
    };

    $.ajax({
        url: '{{url('/')}}/plf-profile/get-shg-data',
        cache: false,
        method: 'get',
        dataType: 'json',
        data: data_val, 
        success: function(res) {
            if (res.status) {
                
                $(".tab1.unmapping").text(`UnMapped SHG Details (${res.unmapped_shg_data.length})`);
                $(".tab1.mapping").text(`Mapped SHG Details (${res.mapped_shg_data.length})`);

                var content = "";
                var mapping_count = 0;
                if(tab == "mapped")
                {
                    if (res.unmapped_shg_data.length === 0) {
                        $(".mapped-container").html('No Data Found');
                    }
                    else{
                        mapping_count = 1;
                    }
                }
                else{
                    if (res.mapped_shg_data.length === 0) {
                        $(".mapped-container1").html('No Data Found');
                    }
                    else{
                        mapping_count = 1;
                    }
                }
                console.log(mapping_count);
                console.log(tab);
                if (mapping_count == 1) {
                    // $(".mapped-container").html('No Data Found'); 
                    content += ``;
                    if(tab == "mapped")
                    {
                        for (var i = 0; i < res.unmapped_shg_data.length; i++) {
                        content += `<tr>
                            <td><input type="checkbox" class="row-checkbox" name="shg_id[]" value="${res.unmapped_shg_data[i].id}"></td>
                            <td>${res.unmapped_shg_data[i].shg_name}</td>
                            <td>${res.unmapped_shg_data[i].formation_date}</td>
                        </tr>`;
                    }
                    $("#mapped_list").html(content);
                    }
                    else{
                        // console.log("Dfgdgdfg");
                        for (var i = 0; i < res.mapped_shg_data.length; i++) {
                        content += `<tr>
                            <td><input type="checkbox" class="row-checkbox" name="shg_id[]" value="${res.mapped_shg_data[i].id}"></td>
                            <td>${res.mapped_shg_data[i].shg_name}</td>
                            <td>${res.mapped_shg_data[i].formation_date}</td>
                        </tr>`;
                    }
                    $("#mapped_list1").html(content);

                    }
                  

                    content += ``;

                 
                    
                    

                    // Initialize checkbox event handlers
                    const mapButton = $(".map-button");
                    const checkboxess = $(".row-checkbox");

                    function toggleMapButton() {
                        const anyChecked = checkboxess.is(":checked");
                        mapButton.toggle(anyChecked);
                    }

                    // Add event listener to each checkbox
                    checkboxess.on("change", toggleMapButton);

                    // Handle "Select All" checkbox
                    $("#select-all-rows").on("change", function() {
                        checkboxess.prop("checked", this.checked);
                        toggleMapButton();
                    });

                    // Handle "Select All" checkbox (main checkbox)
                    $("#select-all").on("change", function() {
                        $("#select-all-rows").prop("checked", this.checked).trigger("change");
                    });

                    // Search functionality
                    $("#search").on("input", function() {
                        var filter = this.value.toLowerCase();
                        $("#shg-table tbody tr").each(function() {
                            var cells = $(this).find("td");
                            var match = cells.toArray().some(cell => $(cell).text().toLowerCase().includes(filter));
                            $(this).toggle(match);
                        });
                    });

                    // Map button click event
                    mapButton.on("click", function() {
                        var data_value = $(this).attr("data-val");
                        const selectedValues = checkboxess.filter(":checked").map(function() {
                            return $(this).val();
                        }).get();
                        $.ajax({
                            url: '{{url('/')}}/plf-profile/map-shg-data',
                            cache: false,
                            method: 'post',
                            dataType: 'json',
                            data: {data:selectedValues,data_val:$(this).attr("data-val")}, 
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                // console.log(res);
                                // if(data_value == "map")
                                // {
                                //     habitation('unmapped');
                                // }
                                // else{
                                    habitation('mapped');
                                // }
                                // $("#habitation").change(); 
                                
                                
                            }
                        });

                        console.log("Selected values:", selectedValues);

                        // You can now use `selectedValues` as needed, e.g., send them in an AJAX request
                    });
                }
            }
        }
    });
    }
    $("#habitation").change(function() {
   habitation('mapped');
});
$(document).on('change', '.habitation', function() {
    var index = $(this).attr("index");
    var data_val = {
        data: $(this).val(),
        index: index
    };
    var this_dt = $(this);
    $.ajax({
        url: '{{url('/')}}/plf-profile/get-shg-datas',
        cache: false,
        method: 'get',
        dataType: 'json',
        data: data_val, 
        success: function(res) {
            if (res.status) {
                var get_content = `<option value="" selected="" disabled=""> Select SHG </option>`;
                for(var i=0;i<res.mapped_shg_data.length;i++) {
                    get_content += `<option value="${res.mapped_shg_data[i].id}">${res.mapped_shg_data[i].shg_name}</option>`;
                }
                console.log(this_dt);
                this_dt.closest(".ec-section").find('.shg_group').html(get_content); 
                // $(".shg_group_" + index).html(get_content); // Populate the SHG dropdown
            }
        }
    });
});

$(document).on('change', '.shg_group', function() {
    var index = $(this).attr("index");
    var data_val = {
        data: $(this).val()
    };
    var this_dt = $(this);
    $.ajax({
        url: '{{url('/')}}/plf-profile/get-shg-member-datas',
        cache: false,
        method: 'get',
        dataType: 'json',
        data: data_val, 
        success: function(res) {
            if (res.status) {
                var get_content1 = '<option value="" selected="" disabled=""> Select SHG Member </option>';
                for(var i=0;i<res.mapped_shg_data.length;i++) {
                    get_content1 += `<option value="${res.mapped_shg_data[i].id}">${res.mapped_shg_data[i].member_name}</option>`;
                }
                console.log(get_content1);
                this_dt.closest(".row").find(".shg_member").html(get_content1);
                // $(".shg_member_" + index).html(get_content1); // Populate the SHG Member dropdown
            }
        }
    });
});




    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;

        // Hide all tab contents
        tabcontent = document.getElementsByClassName("tab-content1");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
            tabcontent[i].classList.remove("active");
        }

        // Remove the active class from all tabs
        tablinks = document.getElementsByClassName("tab1");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }

        // Show the current tab and add an "active" class to the clicked tab
        document.getElementById(tabName).style.display = "block";
        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");
        habitation(tabName);
    }
    
    document.getElementById('add-section1').addEventListener('click', function() {
        let ecSectionss = document.getElementById('bank-account-details');
        let newSection = ecSectionss.children[0].cloneNode(true);
        let sectionIndex = ecSectionss.children.length; 
        newSection.querySelectorAll('input, select').forEach(function(input) {
            let name = input.name;
            let id = input.id;
          
            input.name = name.replace(/\[\d+\]/, '[' + sectionIndex + ']');
            input.id = id.replace(/\d+$/, sectionIndex);
            input.index = sectionIndex; 
            input.value = '';
             // Re-initialize select2 for the select element
            // if (input.tagName.toLowerCase() === 'select') {
            //     // console.log(input.id);
            //     $(input).select2();  // Initialize select2
            // }
        });
        newSection.querySelector('.serial-no1').textContent = sectionIndex + 1;
        $("#banks_"+sectionIndex+"").select();
        $("#branches_"+sectionIndex+"").select();
        ecSectionss.appendChild(newSection);
    });
    document.getElementById('add-section').addEventListener('click', function() {
        let ecSections = document.getElementById('ec-sections');
        let newSection = ecSections.children[0].cloneNode(true);
        let sectionIndex = ecSections.children.length;
        // console.log(sectionIndex);
        newSection.querySelectorAll('input, select').forEach(function(input) {
            let name = input.name;
          
            input.name = name.replace(/\[\d+\]/, '[' + sectionIndex + ']');
            input.index = sectionIndex;
            input.value = '';
        });
        newSection.querySelector('.serial-no').textContent = sectionIndex + 1;

        ecSections.appendChild(newSection);
    });
    $(".save-office").click(function(){
        var form_data = new FormData($("#exampleForm4")[0]); 
            $.ajax({
                    url: '{{url('/')}}/plf-profile/stage/{{$profile->id}}/4',
                    cache: false,
                    method:'post', 
                    dataType:'json',
                    data:form_data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        $.toast({
                                heading: '',
                                text: "Updated Successfully",
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 1000,
                                stack: 1
                            });
                            setTimeout(() => {
                                $("ul.nav-tabs li a").removeClass("active");
                                $("ul.nav-tabs li a#bmmu_detailsss").addClass("active");
                                $(".office_bearers").removeClass("active");
                                $(".bmmu_detail").addClass("active");
                                window.scrollTo({
                                    top: 0,
                                    behavior: 'smooth' // Optional: 'smooth' or 'auto'
                                    });
                            }, 1500); // 2000 milliseconds = 2 seconds
                        // console.log(res);
                        // window.location.reload();
                      
                    }
                });
    })
    $(".save-bmmu").click(function(){
        var form_data = new FormData($("#exampleForm5")[0]); 
            $.ajax({
                    url: '{{url('/')}}/plf-profile/stage/{{$profile->id}}/5',
                    cache: false,
                    method:'post', 
                    dataType:'json',
                    data:form_data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        $.toast({
                                heading: '',
                                text: "Updated Successfully",
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 1000,
                                stack: 1
                            });
                            setTimeout(() => {
                                window.location.reload();
                                // $("ul.nav-tabs li a").removeClass("active");
                                // $("ul.nav-tabs li a#bmmu_detailsss").addClass("active");
                                // $(".office_bearers").removeClass("active");
                                // $(".bmmu_detail").addClass("active");
                                // window.scrollTo({
                                //     top: 0,
                                //     behavior: 'smooth' // Optional: 'smooth' or 'auto'
                                //     });
                            }, 1500); // 2000 milliseconds = 2 seconds
                        // console.log(res);
                        // window.location.reload();
                      
                    }
                });
    })
    $(".submit-ec").click(function(){
        var form_data = new FormData($("#exampleForm3")[0]); 
            $.ajax({
                    url: '{{url('/')}}/plf-profile/stage/{{$profile->id}}/3',
                    cache: false,
                    method:'post', 
                    dataType:'json',
                    data:form_data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        $.toast({
                                heading: '',
                                text: "Updated Successfully",
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 1000,
                                stack: 1
                            });
                            setTimeout(() => {
                                $("ul.nav-tabs li a").removeClass("active");
                                $("ul.nav-tabs li a#office_bearerssss").addClass("active");
                                $(".executive_mapping").removeClass("active");
                                $(".office_bearers").addClass("active");
                                window.scrollTo({
                                    top: 0,
                                    behavior: 'smooth' // Optional: 'smooth' or 'auto'
                                    });
                            }, 1500); // 2000 milliseconds = 2 seconds
                        // console.log(res);
                        // window.location.reload();
                      
                    }
                });
    })
    $(".submit-ec2").click(function(){
        
        var plf_id = $("#plf_id").val();
        $.ajax({
        url: '{{url('/')}}/plf-profile/get-ec',
        cache: false,
        method: 'get',
        dataType: 'json',
        data: {plf_id:plf_id}, 
        success: function(res) {
            console.log(res);
            if(res.status)           
            {
                if(res.get_ec_data == 0)
            {
                popup_init();
                $(".modal-dialog").addClass("actv");
                popup_data('<h3 style="text-align:center">No Data Found</h3>');
            }
            else{
                popup_init();
                var contenttt =  `<div><h4 style="font-weight:bold">${res.get_ec_data[0].plf_name}</h4></div><table>
    <thead>
        <tr>
            <th>SHG Name</th> 
            <th>Panchayat Name</th>
            <th>Member Name</th>
            <th>Start Date</th>
            <th>End Date</th>
        </tr>
    </thead>
    <tbody id="shg-data-body">
    `; 
            $.each(res.get_ec_data, function(index, row) {
                var tableRow = '<tr>' +
                    '<td>' + (row.shg_name || 'N/A') + '</td>' + 
                    '<td>' + row.village_name + '</td>' +
                    '<td>' + row.shg_member_name + '</td>' +
                    '<td>' + row.from_date + '</td>' +
                    '<td>' + row.to_date + '</td>' +
                    '</tr>';
                    contenttt+=tableRow; 
            });
            contenttt+=` </tbody>
            </table>`;
            console.log(contenttt);
            popup_data(contenttt);
            }
             
            }
            // popup_data()
console.log(plf_id);
        }
    });
    })
    // $(".office_bearerssss").click(function(){
    //     // alert("Sgffdg");
    //     console.log("vdfdfgfdgdg");
    //     $.ajax({
    //     url: '{{url('/')}}/plf-profile/get-office-bearers',
    //     cache: false,
    //     method: 'get',
    //     dataType: 'json',
    //     data: {plf_id:plf_id}, 
    //     success: function(res) {
    //         console.log(res);
    //     }
    // }); 

    // })
    $(document).on('input', '.ifsc-input', function() {
    var $this = $(this);
    if ($this.val().length === 11) {
        $this.closest(".bank_ifsc").find("#fetchbank").prop('disabled', false);
    } else {
        $this.closest(".bank_ifsc").find("#fetchbank").prop('disabled', true );
    }
});
$(document).on('click', '.fetchbank', function() { 
    var plf_id = $("#plf_id").val();
    var $this_dt = $(this);
    var ifsc_code = $(this).closest(".bank_ifsc").find(".ifsc-input").val();
    
    // alert(ifsc_code);
        $.ajax({
        url: '{{url('/')}}/plf-profile/check-ifsc/'+ifsc_code+'',
        cache: false,
        method: 'get',
        dataType: 'json',
        data: {plf_id:plf_id}, 
        success: function(res) {
            if(res.status)
            {
                if(res.bank_details.length == 0)
                {
                    $this_dt.closest(".account-name").find(".select2-container1").show();
                    $this_dt.closest(".account-name").find(".select2-container2").show();
                    $this_dt.closest(".account-name").find("#BankName").hide();
                    $this_dt.closest(".account-name").find("#BranchName").hide();
                    // $(".select2-container1").show();
                    // $(".select2-container2").show();
                    // $("#BankName").hide();
                    // $("#BranchName").hide(); 
                }
                else{
                    $this_dt.closest(".account-name").find(".select2-container1").hide();
                    $this_dt.closest(".account-name").find(".select2-container2").hide();
                    $this_dt.closest(".account-name").find("#BankName").show();
                    $this_dt.closest(".account-name").find("#BranchName").show(); 
                    $this_dt.closest(".account-name").find(".banks").val(res.bank_details[0].bank_name);
                    $this_dt.closest(".account-name").find(".banks").val(res.bank_details[0].bank_name);
                    $this_dt.closest(".account-name").find("#BankName").val(res.bank_details[0].bank_name);
                    $this_dt.closest(".account-name").find("#BranchName").val(res.bank_details[0].branch_name);
                    // $("#BankName").val(res.bank_details[0].bank_name);
                    // $("#BranchName").val(res.bank_details[0].branch_name);
                }
            }
        }
    });
})

document.getElementById('save-bank').addEventListener('click', function(event) {
        // Prevent form submission
        event.preventDefault();

        // Get form elements
        const VONameasperPassbook = document.getElementById('VONameasperPassbook').value.trim();
        const IFSC = document.getElementById('IFSC11').value.trim();
        const AccountNumber = document.getElementById('AccountNumber').value.trim();
        const RetypeAccNo = document.getElementById('RetypeAccNo').value.trim();
        const AccountType = document.getElementById('AccountType').value;
        const AccountOpeningDate = document.getElementById('AccountOpeningDate').value;
        const PassbookPageUpload = document.getElementById('PassbookPageUpload').value;

        // Check for empty fields
        if (!VONameasperPassbook || !IFSC || !AccountNumber || !RetypeAccNo || !AccountType || !AccountOpeningDate || !PassbookPageUpload) {
            alert('Please fill out all fields.');
            return false;
        }

        // Check if Account Number and Retype Account Number match
        if (AccountNumber !== RetypeAccNo) {
            alert('Account Number and Retype Acc No do not match.');
            return false;
        }

        // If validation passes, you can submit the form
        // event.target.submit();
        alert('Form submitted successfully!');
    });
  </script>

@endsection