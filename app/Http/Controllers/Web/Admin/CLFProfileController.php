<?php

namespace App\Http\Controllers\Web\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Country;
use App\Models\District;
use App\Models\Blocks;
use App\Models\Panchayat;
use App\Models\PlfProfile;
use App\Models\ClfProfile;
use App\Models\Bankdetails;
use App\Models\Ec;
use App\Models\OfficeBearers;
use App\Models\ClfBankProfile;
use App\Models\Admin\Driver;
use App\Models\MembershipTariff;
use App\Models\Admin\Company;
use App\Base\Constants\Auth\Role;
use App\Models\Admin\UserDetails; 
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Web\BaseController;
use App\Base\Constants\Auth\Role as RoleSlug;
use App\Base\Filters\Master\CommonMasterFilter;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use App\Base\Services\ImageUploader\ImageUploaderContract;
use App\Models\Request\Request as RequestRequest;
use App\Base\Filters\Admin\RequestFilter;
use App\Models\Payment\UserWalletHistory;
use App\Models\Payment\UserWallet;
use App\Http\Requests\Admin\User\AddUserMoneyToWalletRequest;
use App\Base\Constants\Setting\Settings;
use Illuminate\Support\Str;
use App\Base\Constants\Masters\WalletRemarks;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\Notifications\SendPushNotification;
use Mail;
use Illuminate\Http\Request;
use App\Models\UsersMembership;
use App\Jobs\Notifications\Auth\Registration\UserNotification;

class CLFProfileController extends BaseController
{
    /**
     * The User Details model instance.
     *
     * @var \App\Models\Admin\UserDetails
     */
    protected $user_details ;

    /**
     * The User model instance.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * The
     *
     * @var App\Base\Services\ImageUploader\ImageUploaderContract
     */
    protected $imageUploader;


    /**
     * User Details Controller constructor.
     *
     * @param \App\Models\Admin\UserDetails $user_details
     */
    public function __construct(UserDetails $user_details, ImageUploaderContract $imageUploader, User $user)
    {
        $this->user_details = $user_details;
        $this->imageUploader = $imageUploader;
        $this->user = $user;
    }
    public function get_generation_clf($user_data){
        $length = 3;

        // Shuffle the string
        $shuffledString = str_shuffle($user_data['dist_name']);

        // Get the first $length characters
        $randomChars = substr($shuffledString, 0, $length);
       return $randomChars.time();
    }

    public function get_generation($village_code,$user_data){
        $length = 3;

        // Shuffle the string
        $shuffledString = str_shuffle($user_data['dist_name']);

        // Get the first $length characters
        $randomChars = substr($shuffledString, 0, $length);
       return $village_code."".$randomChars;
    }

    /**
    * Get all users
    * @return \Illuminate\Http\JsonResponse
    */
    public function index()
    {
        $page = trans('pages_names.users');

        $main_menu = 'clf_profile';
        $sub_menu = 'clf_profile';
        $sub_menu_1 = 'clf_profile';
        if(!session('user_details'))
        {
            return redirect('/login');
        }
        $user_data = session('user_details');  
        $get_panchat = Blocks::where('blockname',$user_data['block_name'])->first();
        $check_plf_profiles = ClfProfile::where('block',$get_panchat->id)->get(); 
        // dd($check_plf_profiles);
        if(count($check_plf_profiles) == 0)
        {  
                $plf_profile = new ClfProfile();
                $plf_profile->block = $get_panchat->id; 
                $vo_id = $this->get_generation_clf($user_data);
                $plf_profile->vo_id = $vo_id;
                $plf_profile->vo_code = time(); 
                $plf_profile->save(); 
        }
        return view('admin.clfprofiles.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    /**
    * Get all users
    * @return \Illuminate\Http\JsonResponse
    */
    public function view(User $user)
    {
        $page = trans('pages_names.users'); 
        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = 'active_user';
        $membership_tariff = MembershipTariff::get(); 
        return view('admin.clfprofiles.view', compact('page', 'main_menu', 'sub_menu','sub_menu_1','user','membership_tariff'));
    }

      /**
    * Get all users
    * @return \Illuminate\Http\JsonResponse
    */
    public function viewBankProfile(ClfProfile $profile)
    { 
         // dd("fgdfgfdgdfgdf");
         $page = trans('pages_names.users');

         $main_menu = 'clf_profile';
         $sub_menu = 'clf_profile';
         $sub_menu_1 = 'clf_profile';
         if(!session('user_details'))
         {
             return redirect('/login');
         }
          
         
         return view('admin.bank_account.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1','profile'));
    }

    public function getbank_date(ClfProfile $profile,QueryFilterContract $queryFilter)
    {
        $url = request()->fullUrl(); //get full url
        $user_data = session('user_details');
        $get_panchat = Blocks::where('blockname',$user_data['block_name'])->first(); 
        $check_plf_profiles = ClfProfile::where('block',$get_panchat->id)->get(); 
        $query = ClfBankProfile::where('clf_id',$profile->id);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();  
        return view('admin.bank_account._user', compact('results'));
    }

        /**
    * Get all users
    * @return \Illuminate\Http\JsonResponse
    */
    public function profilesave(ClfProfile $profile,$stage,Request $request)
    { 
        // dd($request->all());
        if($request)
        {
            switch($stage)
            {
                case 1:
                    $profile->vo_name = $request->vo_name;
            $profile->fomation_date = $request->Formation_date;
            $profile->promoted_by = $request->promoted_by; 
            if($request->Last__Office)
            {
                $profile->last_office_bearer_elected_date = $request->Last__Office; 
            }
            if($request->TenureofOB1election)
            {
                $profile->ob_election_tenure = $request->TenureofOB1election; 
            } 
            if($request->NoofVOsUndertheVO)
            {
                $profile->total_shg = $request->NoofVOsUndertheVO; 
            } 
            if($request->is_lawn)
            {
                $profile->is_vo_registered = 1; 
                $profile->register_no = $request->Registration__Number;
                $profile->register_act = $request->reg_copy;
                if ($uploadedFile = $this->getValidatedUpload('Registration_ofVO', $request)) {
                    $profile_reg = $this->imageUploader->file($uploadedFile)
                        ->saveClfProfilePicture();
                    $profile->registered_copy = $profile_reg;
                }
               
            }
            else{
                $profile->is_vo_registered = 0; 
            }
            // dd($request->VOActive);
            $profile->status = $request->VOActive;  
            $profile->save();
            return response()->json(['status'=>"success","message"=>"Updated Successfully"]);
                    break;

            case 3: 
                // dd($profile->id);
                $ec_datas = $request->ec;
                foreach($ec_datas as $k=>$v)
                {
                    
                    $shg = Shg::find($v['shg_group']);
                    $habitation = Habitation::find($v['habitation1']);
                    $shg_member = Shgmember::find($v['shg_member']);
                    $ec_data = new Ec();
                    $ec_data->clf_id = $profile->id;
                    $ec_data->panchayat = $profile->panchayat;
                    $ec_data->shg_id = $v['shg_group'];
                    $ec_data->habitation_id = $v['habitation1'];
                    $ec_data->shg_member_id = $v['shg_member'];
                    $ec_data->from_date = $v['frmdate'];
                    $ec_data->to_date = $v['todate'];
                    $ec_data->plf_name = $profile->vo_name;
                    $ec_data->village_name = $profile->PanchayatDetails->villagename;
                    $ec_data->habitation_name = $habitation->habitation;
                    $ec_data->shg_name = $shg->shg_name;
                    $ec_data->shg_member_name = $shg_member->member_name;
                    $ec_data->save();

                }
                return response()->json(['status'=>"success","message"=>"Updated Successfully"]);
                
                break;

                case 4 :
                    OfficeBearers::where('clf_id',$request->clf_id)->delete();
                    // dd($request->all());
                    if($request->president)
                    {
                        $office_bearer = new OfficeBearers(); 
                        $office_bearer->clf_id = $request->clf_id;
                        $office_bearer->ec_member_id = $request->president;
                        $office_bearer->from_date = $request->president_from_date;
                        $office_bearer->to_date = $request->president_to_date;
                        if($request->Signatory)
                        {
                            if($request->Signatory == "No")
                            {
                                $office_bearer->signatory = 0;
                            }
                            else{
                                $office_bearer->signatory = 1;
                            } 
                        }
                        else{
                            $office_bearer->signatory = 0;
                        } 
                        $office_bearer->office_type = 1;
                        $office_bearer->save();
                    } 
                    if($request->secretary)
                    {
                        $office_bearer = new OfficeBearers(); 
                        $office_bearer->clf_id = $request->clf_id;
                        $office_bearer->ec_member_id = $request->secretary;
                        $office_bearer->from_date = $request->secretary_from_date;
                        $office_bearer->to_date = $request->secretary_to_date;
                        if($request->secretary_signatory)
                        {
                            if($request->secretary_signatory == "No")
                            {
                                $office_bearer->signatory = 0;
                            }
                            else{
                                $office_bearer->signatory = 1;
                            }
                            
                        }
                        else{
                            $office_bearer->signatory = 0;
                        } 
                        $office_bearer->office_type = 2;
                        $office_bearer->save();
                    } 
                    if($request->treasure)
                    {
                        $office_bearer = new OfficeBearers(); 
                        $office_bearer->clf_id = $request->clf_id;
                        $office_bearer->ec_member_id = $request->treasure;
                        $office_bearer->from_date = $request->treasure_from_date;
                        $office_bearer->to_date = $request->treasure_to_date;
                        if($request->treasure_signatory)
                        {
                            if($request->treasure_signatory == "No")
                            {
                                $office_bearer->signatory = 0;
                            }
                            else{
                                $office_bearer->signatory = 1;
                            }
                            
                        }
                        else{
                            $office_bearer->signatory = 0;
                        } 
                        $office_bearer->office_type = 3;
                        $office_bearer->save();
                    } 
                    if($request->bookkeeper)
                    {
                        $office_bearer = new OfficeBearers(); 
                        $office_bearer->clf_id = $request->clf_id;
                        $office_bearer->ec_member_id = $request->bookkeeper;
                        $office_bearer->from_date = $request->bookkeeper_from_date;
                        $office_bearer->to_date = $request->bookkeeper_to_date;
                        if($request->bookkeeper_signatory)
                        {
                            if($request->bookkeeper_signatory == "No")
                            {
                                $office_bearer->signatory = 0;
                            }
                            else{
                                $office_bearer->signatory = 1;
                            }
                            
                        }
                        else{
                            $office_bearer->signatory = 0;
                        } 
                        $office_bearer->office_type = 4;
                        $office_bearer->save();
                    } 
                    return response()->json(['status'=>"success","message"=>"Updated Successfully"]);
                    break;

                    case 5: 
                        // dd($request->all());
                        $profile->address = $request->address; 
                        $profile->pincode = $request->pincode; 
                        $profile->latitude = $request->latitude; 
                        $profile->logitude = $request->logitude; 
                        if($request->internet)
                        {
                            if($request->internet == "No")
                            {
                                $profile->internet = 0; 
                            }
                            else{
                                if($request->service_provider_name)
                                {
                                    $profile->internet = 1; 
                                    $profile->service_provider_name = $request->service_provider_name; 
                                }
                            }
                        }
                        else{
                            $profile->internet = 0; 
                        }

                        if($request->computer)
                        {
                            if($request->computer == "No")
                            {
                                $profile->computer = 0; 
                            }
                            else{
                                $profile->computer = 1; 
                                if($request->Desktop)
                                { 
                                    $profile->is_dekstop_number = 1; 
                                    $profile->dekstop_number = $request->desktopNumber; 
                                }
                                if($request->Laptop)
                                { 
                                    $profile->is_laptop_number = 1; 
                                    $profile->laptop_number = $request->laptopNumber; 
                                }
                                if($request->Printer)
                                { 
                                    $profile->is_printer_number = 1; 
                                    $profile->printer_number = $request->printerNumber; 
                                }
                                if($request->Scanner)
                                { 
                                    $profile->is_scanner_number = 1; 
                                    $profile->scanner_number = $request->scannerNumber; 
                                }
                            }
                        }
                        else{
                            $profile->computer = 0; 
                        } 
                        $profile->BlockhavePanTanDetails = $request->BlockhavePanTanDetails; 
                        // $profile->photo = $request->photo;  
                        $profile->save();
                        return response()->json(['status'=>"success","message"=>"Updated Successfully"]);
                    break;
                    case 6: 
                        // dd($request->all());
                        if($request->bank_id)
                        {
                            $check_already_fund_exists = ClfBankProfile::where('clf_id',$request->clf_id)->where('acc_type',$request->AccountType)->where('id','!=',$request->bank_id)->get();
                        }
                        else{
                            $check_already_fund_exists = ClfBankProfile::where('clf_id',$request->clf_id)->where('acc_type',$request->AccountType)->get();
                        }
                       
                        if(count($check_already_fund_exists) > 0)
                        {
                            return response()->json(['status'=>false,"message"=>"Bank Account Type already Added"]);
                        }
                        else{
                            if($request->plf_bank_id)
                            {
                                $bank_profile = ClfBankProfile::find($request->plf_bank_id);
                            }
                            else{
                                $bank_profile = new ClfBankProfile();
                            }
                            
                            $bank_profile->name = $request->VONameasperPassbook;
                            $bank_profile->clf_id = $request->clf_id;
                            $bank_profile->bank_id = $request->bank_id;
                            $bank_profile->account_number = $request->AccountNumber;
                            $bank_profile->acc_type = $request->AccountType;
                            $bank_profile->acc_opening_date = $request->AccountOpeningDate;
                            $check_plf_data = ClfBankProfile::where('clf_id',$request->clf_id)->get();
                            if(count($check_plf_data) == 0)
                            {
                                $bank_profile->is_primiary_account = 1;
                            }
                            else{
                                if($request->is_lawn1)
                                {
                                    ClfBankProfile::where('clf_id',$request->clf_id)->update(['is_primiary_account'=>0]);
                                    $bank_profile->is_primiary_account = 1;
                                }
                                else{
                                    $bank_profile->is_primiary_account = 0;
                                }
                            }
                           
                            if($request->PassbookPageUpload)
                            {
                                if ($uploadedFile = $this->getValidatedUpload('PassbookPageUpload', $request)) {
                                    $passbokk_url = $this->imageUploader->file($uploadedFile)
                                        ->savePassbookPicture($request->clf_id);
                                    $bank_profile->passbook_file = $passbokk_url;
                                }
                            }
                            $bank_profile->save();
                            return response()->json(['status'=>true,"message"=>"Updated Successfully"]);
                        }
                        
                        break;
                   

            }
            
        }
       
    }

    public function get_index_data(ClfProfile $profile)
    { 
        dd($request->all());
        $ec = Ec::where('clf_id',$profile->id)->get();
        return response()->json(['status'=>true,"message"=>"Updated Successfully","ec"=>$ec]);

    }
    public function get_bank(ClfBankProfile $bankdetails)
    { 
        $bankdetails->banks = Bankdetails::find($bankdetails->bank_id);
        return response()->json(['status'=>true,"message"=>"Updated Successfully","bankdetails"=>$bankdetails]);
    }
    public function get_office_bearers(Request $request)
    {
        $get_office_bearers = OfficeBearers::where('clf_id',$request->clf_id)->get();
        $get_ec_members = Ec::where('clf_id',$request->clf_id)->get();
        return response()->json(['status'=>"success","message"=>"Updated Successfully","data"=>$get_ec_members]);
    }

    public function getAllUser(QueryFilterContract $queryFilter)
    {
        $url = request()->fullUrl(); //get full url
        $user_data = session('user_details');
        $get_panchat = Blocks::where('blockname',$user_data['block_name'])->first(); 
        $check_plf_profiles = ClfProfile::where('block',$get_panchat->id)->get(); 
        $query = ClfProfile::where('block',$get_panchat->id);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate(); 
        // dd($results);
        return view('admin.clfprofiles._user', compact('results'));
    }
//searchUser
    public function searchUser(QueryFilterContract $queryFilter)
    {
        $url = request()->fullUrl(); //get full url

        $query = User::belongsToRole(RoleSlug::USER);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

        return view('admin.clfprofiles._user', compact('results'));
    }


    public function indexDeleted()
    {
        $page = trans('pages_names.users');

        $main_menu = 'users';
        $sub_menu = 'deceased';
        $sub_menu_1 = 'deceased';

        return view('admin.clfprofiles.deleted-index', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    public function getAllDeletedUser(QueryFilterContract $queryFilter)
    {
        $url = request()->fullUrl(); //get full url

        $query = User::where('is_deleted', true)->belongsToRole(RoleSlug::USER);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

        return view('admin.clfprofiles._deleted-user', compact('results'));
    }


/*inactive Users*/
    public function indexInactive()
    {
        $page = trans('pages_names.users');

        $main_menu = 'users';
        $sub_menu = 'approved';
        $sub_menu_1 = 'in_active_user';

        return view('admin.clfprofiles.inactive-index', compact('page', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    public function getAllInactiveUser(QueryFilterContract $queryFilter)
    {
        $url = request()->fullUrl(); //get full url

        $query = User::where('is_deleted', false)->where('is_approve', 1)->belongsToRole(RoleSlug::USER);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

        return view('admin.clfprofiles._inactive_user', compact('results'));
    }
/*end*/

    /**
    * Create User View
    *
    */
    public function create()
    {
        $page = trans('pages_names.add_user');

        $countries = Country::active()->get();

        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';

        return view('admin.clfprofiles.create', compact('page', 'countries', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    /**
     * Create User.
     *
     * @param \App\Http\Requests\Admin\User\CreateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserRequest $request)
    {
        $created_params = $request->only(['name','mobile','email','country','gender']);
        $created_params['mobile_confirmed'] = true;
        // $created_params['password'] = bcrypt($request->input('password'));

            $created_params['ride_otp'] = rand(1111, 9999);

        $validate_exists_email = $this->user->belongsTorole(Role::USER)->where('email', $request->email)->exists();

        $validate_exists_mobile = $this->user->belongsTorole(Role::USER)->where('mobile', $request->mobile)->exists();

        if ($validate_exists_email) {
            return redirect()->back()->withErrors(['email'=>'Provided email hs already been taken'])->withInput();
        }
        if ($validate_exists_mobile) {
            return redirect()->back()->withErrors(['mobile'=>'Provided mobile hs already been taken'])->withInput();
        }

        if ($uploadedFile = $this->getValidatedUpload('profile_picture', $request)) {
            $created_params['profile_picture'] = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
        }

        $created_params['company_key'] = auth()->user()->company_key;

        $created_params['refferal_code']= str_random(6);

        $created_params['created_by'] = auth()->user()->id;


        $user = $this->user->create($created_params);

        $user->attachRole(RoleSlug::USER);


        $message = trans('succes_messages.user_added_succesfully');

        return redirect('users')->with('success', $message);
    }

    public function getById(User $user)
    {
        $page = trans('pages_names.edit_user');


        $countries = Country::all();
        $results = $user->userDetails ?? $user;
        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';

        return view('admin.clfprofiles.update', compact('page', 'countries', 'main_menu', 'results', 'sub_menu','sub_menu_1'));
    }


    public function update(User $user, UpdateUserRequest $request)
    {
        $updated_params = $request->only(['name','mobile','email','country','gender']);

        $updated_params['updated_by'] = auth()->user()->id;

        if ($uploadedFile = $this->getValidatedUpload('profile_picture', $request)) {
            $updated_params['profile_picture'] = $this->imageUploader->file($uploadedFile)
                ->saveProfilePicture();
        }

        $validate_exists_email = $this->user->belongsTorole(Role::USER)->where('email', $request->email)->where('id', '!=', $user->id)->exists();

        $validate_exists_mobile = $this->user->belongsTorole(Role::USER)->where('mobile', $request->mobile)->where('id', '!=', $user->id)->exists();

        if ($validate_exists_email) {
            return redirect()->back()->withErrors(['email'=>'Provided email hs already been taken'])->withInput();
        }
        if ($validate_exists_mobile) {
            return redirect()->back()->withErrors(['mobile'=>'Provided mobile hs already been taken'])->withInput();
        }

        $user->update($updated_params);

        $message = trans('succes_messages.user_updated_succesfully');

        return redirect('users')->with('success', $message);
    }

    public function toggleStatus(User $user)
    {
        $status = $user->active == 1 ? 0 : 1;

        if($status==1)
        {

            $user->update([
                'active' => $status,
                'is_deleted'=>false,
            ]);
        }else{

            $user->update([
                'active' => $status,
            ]);            
        }


        $message = trans('succes_messages.user_status_changed_succesfully');

            $title = trans('push_notifications.account_inactivated_title',[],$user->lang);
            $body = trans('push_notifications.account_inactivated_body',[],$user->lang);
            $push_data =  ['title' => 'account_inactivated','message' => 'account_inactivated','push_type'=>'account_inactivated'];

       dispatch(new SendPushNotification($user,$title,$body,$push_data));

        return redirect('users')->with('success', $message);
    }
    public function confirm(User $user,Request $request)
    {     
            $membership_data = MembershipTariff::find($request->data);
            $user->update([
                'is_paid_online' => 0,
                'is_payment_done' => 1,
                'payment_mode' => $request->payment_mode,
                'is_approve' => 1,
                'is_deleted'=>false,
                'membership_type'=>$request->data,
                'membership_amount'=>$membership_data->price
            ]);   
            $details = [
                'title' => "Mail from IAS Officers' App",
                'user_details' => $user,
                'type' => 'confirm_email'
            ];  
            $member_ship_data = UsersMembership::where('user_id',$user->id)->first(); 
            $member_ship_data->membership_type = $request->input('data');
            $member_ship_data->payment_mode = $request->input('payment_mode');
            $member_ship_data->is_paid = 1; 
            $member_ship_data->amount = $membership_data->price; 
            $member_ship_data->date = Carbon::now('Asia/kolkata')->format("Y-m-d H:i:s");
            $member_ship_data->expiry_date = Carbon::now('Asia/Kolkata')->addYear()->format("Y-m-d H:i:s");
            $member_ship_data->is_lifetime_member = $membership_data->membership_type; 
            $member_ship_data->save(); 
            Mail::to($user->email)->send(new UserNotification($details)); 
            $sender_id = 'KTSHSC';
            $template_id = '1707168862643740857';
            $phone = $user->mobile;
            $msg = "Payment Done Successfully. Your UserId is ".$user->userid." and Password is ".$user->mobile."";
            $username = 'IndiaklabssOTP';
            $apikey = '4DE5A-8C990';
            $uri = 'https://powerstext.in/sms-panel/api/http/index.php';
            // dd($phone);
            // Construct the URL with query parameters
            $url = $uri . '?' . http_build_query(array(
                'username' => $username,
                'apikey' => $apikey,
                'apirequest' => 'Text',
                'sender' => $sender_id,
                'route' => 'OTP',
                'format' => 'JSON',
                'message' => $msg,
                'mobile' => $phone,
                'TemplateID' => $template_id,
            ));
            
            $ch = curl_init();
            
            // Set the URL
            curl_setopt($ch, CURLOPT_URL, $url);
            
            // Set the HTTP method to GET (since we're sending data in the URL)
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            
            // Set CURLOPT_RETURNTRANSFER so that curl_exec returns the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $response = curl_exec($ch);
            
            // Check for errors
            if(curl_errno($ch)) {
                // echo 'Curl error: ' . curl_error($ch);
                $response = [
                    'status' => true,
                    'message' => curl_error($ch)
                ];
                return response()->json($response);
            } else {
                // Process the response
                // echo $response;
            }
            
            // Close the cURL handle
            curl_close($ch);
            $response = [
                'status' => true,
                'message' => 'Confirmed'
            ];
            return response()->json($response);
    }
    public function send_cred(User $user){
        if($user)
        {
            $details = [
                'title' => "Mail from IAS Officers' App",
                'user_details' => $user,
                'type' => 'send_cred'
            ]; 
            Mail::to($user->email)->send(new UserNotification($details)); 
            $response = [
                'status' => true,
                'message' => 'Confirmed'
            ];
            return response()->json($response);
        }
        
    }
    public function approve(User $user)
    {  
            
            $token = Str::random(32);
            $user->update(['payment_link' => $token]);  
            dd($user);
            $details = [
                'title' => "Mail from IAS Officers' App",
                'user_details' => $user,
                'type' => 'send_payment_link'
            ]; 
            Mail::to($user->email)->send(new UserNotification($details)); 
    
            // Mail::to('ranjith@dubudubu.in')->send(new UserNotification($details));
            $response = [
                'status' => true,
                'message' => 'Approved'
            ];
            return response()->json($response);
    }
    public  function encrypt($data,  $key)
        {
			 $algo='aes-128-cbc';
          
         $iv=substr($key, 0, 16);
                // echo $iv;
            $cipherText = openssl_encrypt(
                    $data,
                    $algo,
                    $key,
                    OPENSSL_RAW_DATA,
                    $iv
                );
        $cipherText = base64_encode($cipherText);
        
return $cipherText;
        
        
        }


public function decrypt($cipherText,  $key)
{
	 $algo='aes-128-cbc';

	 $iv=substr($key, 0, 16);
                echo $iv;
	$cipherText = base64_decode($cipherText);
					
					$plaintext = openssl_decrypt(
                    $cipherText,
                    $algo,
                    $key,
                    OPENSSL_RAW_DATA,
                    $iv
                );
     return $plaintext;   

}  
    public function payment_link(User $user,$payment_link)
    {
        dd("sdfdffsdfs");
        $get_membership_data = UsersMembership::where('user_id',$user->id)->where('is_paid',0)->orderBy('created_at','DESC')->limit(1)->first();
        if($get_membership_data)
        {
             $orderid = "user-$user->id-" . rand(10000, 90000); 
             $MerchantId = "1000356"; 
             $amount = $get_membership_data->amount;
             $key = "MBxNMjIUnjl6H6B6XPEuJCppBxt8lwX9F4rH2Jxhglg="; 
             $SuccessUrl = url('/')."success"; 
             $FailUrl = url('/')."failed"; 
             $requestParameter  = "$MerchantId|DOM|IN|INR|$amount|Other|$SuccessUrl|$FailUrl|SBIEPAY|$orderid|2|NB|ONLINE|ONLINE";
             $multi_parameter = "$amount|INR|GRPT";
             $EncryptTrans = $this->encrypt($requestParameter,$key); 
             $MultiAccountInstructionDtls=$this->encrypt($multi_parameter, $key);
             return view('Payment-success', compact('EncryptTrans', 'MerchantId','MultiAccountInstructionDtls','user','get_membership_data')); 
        }
        
    }
    public function toggleApprove(User $user, $approval_status)
    {
        $user_id = auth()->user()->id;

        $status = (boolean)$approval_status;

        $user->update([
            'approve' => $status,
            'updated_by' => $user_id,
            'is_deleted'=>false,
            
        ]);
        
       $this->database->getReference('users/user_'.$driver->id)->update(['approve'=>(int)$status,'updated_at'=> Database::SERVER_TIMESTAMP]);

        $message = trans('succes_messages.user_approve_status_changed_succesfully');
        $user = User::find($user->user_id);
        if ($status) {
            $title = trans('push_notifications.user_approved',[],$user->lang);
            $body = trans('push_notifications.user_approved_body',[],$user->lang);
            $push_data = ['notification_enum'=>PushEnums::USER_ACCOUNT_APPROVED];
            $socket_success_message = PushEnums::USER_ACCOUNT_APPROVED;
        } else {
            $title = trans('push_notifications.user_declined_title',[],$user->lang);
            $body = trans('push_notifications.user_declined_body',[],$user->lang);
            $push_data = ['notification_enum'=>PushEnums::USER_ACCOUNT_DECLINED];
            $socket_success_message = PushEnums::USER_ACCOUNT_DECLINED;
        }

        $user_details = $user->user;
        $user_result = fractal($user_details, new UserTransformer);
        $formated_user = $this->formatResponseData($user_result);
        // dd($formated_user);
        $socket_params = $formated_user['data'];
        $socket_data = new \stdClass();
        $socket_data->success = true;
        $socket_data->success_message  = $socket_success_message;
        $socket_data->data  = $socket_params;


        dispatch(new SendPushNotification($user,$title,$body));

        return redirect('users')->with('success', $message);
    }
    public function toggleAvailable(User $user)
    {
        $status = $user->available == 1 ? 0 : 1;
        $user->update([
            'available' => $status
        ]);

        $message = trans('succes_messages.user_available_status_changed_succesfully');
        return redirect('users')->with('success', $message);
    }
    public function delete(User $user)
    {
        if(env('APP_FOR')=='demo'){

        $message = 'you cannot delete the user. this is demo version';

        return $message;

        }
        
        $user->update(['is_deleted'=>true, 'active'=>false]);  

        $message = trans('succes_messages.user_deleted_succesfully');

        return $message;
    }
   public function UserTripRequestIndex(User $user)
    {

        $completedTrips = RequestRequest::where('user_id',$user->id)->companyKey()->whereIsCompleted(true)->count();
        $cancelledTrips = RequestRequest::where('user_id',$user->id)->companyKey()->whereIsCancelled(true)->count();

        $card = [];
        $card['completed_trip'] = ['name' => 'trips_completed', 'display_name' => 'Completed Rides', 'count' => $completedTrips, 'icon' => 'fa fa-flag-checkered text-green'];
        $card['cancelled_trip'] = ['name' => 'trips_cancelled', 'display_name' => 'Cancelled Rides', 'count' => $cancelledTrips, 'icon' => 'fa fa-ban text-red'];

        $main_menu = 'users_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';
        $items = $user->id;

        return view('admin.clfprofiles.user-request-list-new', compact('card','main_menu','sub_menu','items','sub_menu_1'));
    }
    public function UserTripRequestNew(QueryFilterContract $queryFilter, User $user)
    {
        $items = $user->id;
       
        $query = RequestRequest::where('requests.user_id', $user->id); // Specify 'requests.user_id' to resolve ambiguity
        
        $results = $queryFilter->builder($query)->customFilter(new RequestFilter)->defaultSort('-created_at')->paginate();

        return view('admin.clfprofiles.user-request-list-view-new', compact('results', 'items'));
    }
    public function UserTripRequest(QueryFilterContract $queryFilter, User $user)
    {
       
        $completedTrips = RequestRequest::where('user_id',$user->id)->companyKey()->whereIsCompleted(true)->count();
        $cancelledTrips = RequestRequest::where('user_id',$user->id)->companyKey()->whereIsCancelled(true)->count();
        $upcomingTrips = RequestRequest::where('user_id',$user->id)->companyKey()->whereIsLater(true)->whereIsCompleted(false)->whereIsCancelled(false)->whereIsDriverStarted(false)->count();

        $card = [];
        $card['completed_trip'] = ['name' => 'trips_completed', 'display_name' => 'Completed Rides', 'count' => $completedTrips, 'icon' => 'fa fa-flag-checkered text-green'];
        $card['cancelled_trip'] = ['name' => 'trips_cancelled', 'display_name' => 'Cancelled Rides', 'count' => $cancelledTrips, 'icon' => 'fa fa-ban text-red'];
        $card['upcoiming_trip'] = ['name' => 'trips_cancelled', 'display_name' => 'Upcoming Rides', 'count' => $upcomingTrips, 'icon' => 'fa fa-calendar'];

        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';



         $query = RequestRequest::where('user_id',$user->id);
        $results = $queryFilter->builder($query)->customFilter(new RequestFilter)->defaultSort('-created_at')->paginate();


        return view('admin.clfprofiles.user-request-list', compact('results','card','main_menu','sub_menu','sub_menu_1'));
    }
    public function UserTripRequestView(QueryFilterContract $queryFilter, User $user)
    {
        $items = $user->id;

        $query = RequestRequest::where('user_id',$user->id);
        $results = $queryFilter->builder($query)->customFilter(new RequestFilter)->defaultSort('-created_at')->paginate();

        return view('admin.clfprofiles.user-request-list-view', compact('results','items'));
    }
    public function userPaymentHistory(User $user)
    {
        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';
        $item = $user;

        $amount = UserWallet::where('user_id',$user->id)->first();

    if ($amount == null) {
         $card = [];
         $card['total_amount'] = ['name' => 'total_amount', 'display_name' => 'Total Amount ', 'count' => "0", 'icon' => 'fa fa-flag-checkered text-green'];
        $card['amount_spent'] = ['name' => 'amount_spent', 'display_name' => 'Spend Amount ', 'count' => "0", 'icon' => 'fa fa-ban text-red'];
        $card['balance_amount'] = ['name' => 'balance_amount', 'display_name' => 'Balance Amount', 'count' => "0", 'icon' => 'fa fa-ban text-red'];

         $history = UserWalletHistory::where('user_id',$user->id)->orderBy('created_at','desc')->paginate(10);
        }else{

         $card = [];
        $card['total_amount'] = ['name' => 'total_amount', 'display_name' => 'Total Amount ', 'count' => $amount->amount_added, 'icon' => 'fa fa-flag-checkered text-green'];
        $card['amount_spent'] = ['name' => 'amount_spent', 'display_name' => 'Spend Amount ', 'count' => $amount->amount_spent, 'icon' => 'fa fa-ban text-red'];
        $card['balance_amount'] = ['name' => 'balance_amount', 'display_name' => 'Balance Amount', 'count' => $amount->amount_balance, 'icon' => 'fa fa-ban text-red'];

         $history = UserWalletHistory::where('user_id',$user->id)->orderBy('created_at','desc')->paginate(10);

        // dd($history);
        }
        return view('admin.clfprofiles.user-payment-wallet', compact('card','main_menu','sub_menu','item','history','sub_menu_1'));
    }
     public function StoreUserPaymentHistory(AddUserMoneyToWalletRequest $request,User $user)
    {
// dd($request);

        $currency = get_settings(Settings::CURRENCY);

        // $converted_amount_array =  convert_currency_to_usd($user_currency_code, $request->input('amount'));

        // $converted_amount = $converted_amount_array['converted_amount'];
        // $converted_type = $converted_amount_array['converted_type'];
        // $conversion = $converted_type.':'.$request->amount.'-'.$converted_amount;
        $transaction_id = Str::random(6);


            $wallet_model = new UserWallet();
            $wallet_add_history_model = new UserWalletHistory();
            $user_id = $user->id;


        $user_wallet = $wallet_model::firstOrCreate([
            'user_id'=>$user_id]);
        $user_wallet->amount_added += $request->amount;
        $user_wallet->amount_balance += $request->amount;
        $user_wallet->save();

        $wallet_add_history_model::create([
            'user_id'=>$user_id,
            'card_id'=>null,
            'amount'=>$request->amount,
            'transaction_id'=>$transaction_id,
            'merchant'=>null,
            'remarks'=>WalletRemarks::MONEY_DEPOSITED_TO_E_WALLET_FROM_ADMIN,
            'is_credit'=>true]);


         $message = "money_added_successfully";
        return redirect()->back()->with('success', $message);


    }

    public function importUser(){

        $page = trans('pages_names.users');

        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';


        Excel::import(new UsersImport, request()->file('file'));

             $message = trans('succes_messages.user_import_succesfully');

        return redirect('users')->with('success', $message);

    }

     public function downloadFile()
    {
        $sampleFile = public_path()."/assets/sample_file/sample_file.csv";

        $headers = array(
         'Content-Type : application/csv',
        );


        return response()->download($sampleFile);
    }
    public function UserCancelRequestIndex(User $user)
    {

        $results = $user->userCancellationFee()->paginate();
        // dd($results);

        $page = trans('pages_names.assign_types');

        $main_menu = 'drivers_and_users';
        $sub_menu = 'users';
        $sub_menu_1 = '';

        return view('admin.clfprofiles.cancellation', compact('results', 'page', 'main_menu', 'sub_menu', 'user','sub_menu_1'));

    }    
        /**
    * Create User View
    *
    */
    public function checkifsc($ifsc)
    {
        $page = trans('pages_names.add_user');

        $countries = Country::active()->get();

        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';
        $bank_details = Bankdetails::where('ifsc_code',$ifsc)->get();
        $bank_names = Bankdetails::groupBy('bank_name')->get();
        return response()->json(['status'=>true,"bank_details"=>$bank_details,"bank_names"=>$bank_names]);
    }

      /**
    * Create User View
    *
    */
    public function getbranches(Bankdetails $bank)
    {
        $page = trans('pages_names.add_user');

        $countries = Country::active()->get();

        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';

        $bank_details = Bankdetails::where('bank_name',$bank->bank_name)->get(); 
        return response()->json(['status'=>true,"bank_details"=>$bank_details]);
    }

     /**
    * Create User View
    *
    */
    public function addBankProfile()
    {
        $page = trans('pages_names.add_user');

        $countries = Country::active()->get();

        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';

        return view('admin.bank_account.create', compact('page', 'countries', 'main_menu', 'sub_menu','sub_menu_1'));
    }

    public function openbalance(){
        // dd("sdfsfsf");
        $page = trans('pages_names.users');

        $main_menu = 'clf_profile';
        $sub_menu = 'clf_profile_open';
        $sub_menu_1 = 'clf_profile';
        $user_data = session('user_details');  
        $blocks_data = Blocks::where('blockname',$user_data['block_name'])->first();
        $clfprofile = ClfProfile::where('block',$blocks_data->id)->first(); 
        // dd($blocks_data);
        return view('admin.ClfProfiles.openbalance', compact('clfprofile', 'page', 'main_menu', 'sub_menu','sub_menu_1','blocks_data'));
    }
    public function list_banks(ClfProfile $profile,QueryFilterContract $queryFilter){
        
        $query = ClfBankProfile::where('clf_id',$profile->id);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();  
        return view('admin.ClfProfiles._openbalance', compact('results'));
    }


    public function openbalanceedit(ClfBankProfile $profile)
    {
        $page = trans('pages_names.edit_user');


        $countries = Country::all();
        $results = $profile;
        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';
        // print_r($profile->profile->BlockDetails->blockname);
        // exit;
        return view('admin.ClfProfiles.update', compact('page', 'countries', 'main_menu', 'results', 'sub_menu','sub_menu_1'));
    }

    public function openbalanceupdate(ClfBankProfile $profile,Request $request)
    {
        $page = trans('pages_names.edit_user');
        // dd($request->all());

        $countries = Country::all();
        $results = $profile;
        $main_menu = 'drivers_and_users';
        $sub_menu = 'user_details';
        $sub_menu_1 = '';
        $profile->total_amount = $request->amount;
        $profile->opening_balance = $request->balance;
        if($request->front_copy)
        {
            if ($uploadedFile = $this->getValidatedUpload('front_copy', $request)) {
                $passbokk_url = $this->imageUploader->file($uploadedFile)
                    ->savePassbookPicture($profile->clf_id);
                $profile->passbook_front_copy = $passbokk_url;
            }
        }
        if($request->back_copy)
        {
            if ($uploadedFile = $this->getValidatedUpload('back_copy', $request)) {
                $passbokk_url1 = $this->imageUploader->file($uploadedFile)
                    ->savePassbookPicture($profile->clf_id);
                $profile->passbook_back_copy = $passbokk_url1;
            }
        }
 
        $profile->save(); 
        // dd($profile->profile->PanchayatDetails->id);
        return redirect('clf-profile/open-balance')->with('success', 'Updated Successfully');
        
    }
    public function getbank(ClfProfile $profile,QueryFilterContract $queryFilter)
    {
        $url = request()->fullUrl(); //get full url
        $user_data = session('user_details'); 
        $check_plf_profiles = ClfBankProfile::where('clf_id',$profile->id)->get(); 
        $query = ClfBankProfile::where('clf_id',$profile->id); 
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate(); 
        // dd($results[0]->Bankdetails);
        return view('admin.clfprofiles._banks', compact('results'));
    }
}

