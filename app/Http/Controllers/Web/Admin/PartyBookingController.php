<?php

namespace App\Http\Controllers\Web\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\PartyBooking;
use App\Models\Tariff;
use Illuminate\Http\Request;
use App\Models\Admin\VehicleType;
use App\Models\Admin\ServiceLocation;
use App\Http\Controllers\ApiController;
use App\Base\Constants\Auth\Role as RoleSlug;
use App\Base\Filters\Master\CommonMasterFilter;
use App\Http\Controllers\Api\V1\BaseController;
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use App\Base\Services\ImageUploader\ImageUploaderContract;
use App\Http\Requests\Admin\VehicleTypes\CreateVehicleTypeRequest;
use App\Http\Requests\Admin\VehicleTypes\UpdateVehicleTypeRequest;
use App\Base\Constants\Auth\Role;
use App\Models\Invoice;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;
/**
 * @resource Vechicle-Types
 *
 * vechicle types Apis
 */
class PartyBookingController extends BaseController
{
    /**
     * The VehicleType model instance.
     *
     * @var \App\Models\Admin\VehicleType
     */
    protected $vehicle_type;

    /**
     * VehicleTypeController constructor.
     *
     * @param \App\Models\Admin\VehicleType $vehicle_type
     */
    public function __construct(VehicleType $vehicle_type, ImageUploaderContract $imageUploader,User $user)
    {
        $this->vehicle_type = $vehicle_type;
        $this->imageUploader = $imageUploader;
        $this->user = $user;
    }

    /**
    * Get all vehicle types
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(Request $request)
    { 
    //    dd("sdvsdfs");
        $page = trans('pages_names.types');
        $main_menu = 'room';
        $sub_menu = 'party-booking';
        // if($request->type == "pending")
        // {
        //     $sub_menu = 'pending-booking';
        //     $title = 'Pending Party Booking';
        // }
        // if($request->type == "checkin")
        // {
        //     $sub_menu = 'checkin-booking';
        //     $title = 'Checkin Party Booking';
        // }
        // if($request->type == "cancelled")
        // {
        //     $sub_menu = 'cancelled-booking';
        //     $title = 'Cancelled Party Booking';
        // }
        // if($request->type == "completed")
        // {
        //     $sub_menu = 'completed-booking';
        //     $title = 'Completed Party Booking';
        // }
        $sub_menu_1 = '';
        $user = $this->user->belongsTorole(Role::USER)->get(); 
        return view('admin.party_booking.index', compact('page', 'main_menu', 'sub_menu','sub_menu_1','user'))->render();
    }

    public function getAllTypes(QueryFilterContract $queryFilter,Request $request)
    { 
        // dd($request->all());
        if(auth()->user()->hasRole('super-user') || auth()->user()->hasRole('mess-manager'))
        {
            $query = PartyBooking::query();
        }
        else{
            $query = PartyBooking::where('user_id',auth()->user()->id);
        } 
        if($request->status)
        {
            $status = $request->status; 
            // dd($status);
            switch ($status) {
                case 2: 
                    $query->where('status',0);
                    break;
                case 3:
                    $query->where('status',1);
                    break;
                case 4:
                    $query->where('status',3);
                    break;
                case 5:
                        $query->where('status',2);
                        break;
                default:
                     
                    // Handle invalid type
            }
        }
       
        if($request->payment_status)
        {
            $payment_status = $request->payment_status;
            switch ($payment_status) {
                case 1:
                    $query->where('is_paid',1);
                    break;
                case 2: 
                    $query->where('is_paid',0);
                    break;
               
            }
        }
        if($request->date_value)
        {
            $date_value = $request->date_value;
            switch ($date_value) {
                case 1:
                     $fromDate = Carbon::createFromFormat('Y-m-d', $request->input('from_date'))->startOfDay();
                     $toDate = Carbon::createFromFormat('Y-m-d', $request->input('to_date'))->endOfDay();
                    
                    $query->whereBetween('checkin_date', [$fromDate, $toDate]);
                    break;
                case 2:
                    
                    $today = Carbon::today('Asia/Kolkata');
                    // dd($today);
                    $query->whereDate('checkin_date', $today);
                    break;
                case 3:
                    $startOfWeek = Carbon::now('Asia/Kolkata')->startOfWeek();
                    $endOfWeek = Carbon::now('Asia/Kolkata')->endOfWeek(); 
                    $query->whereBetween('checkin_date', [$startOfWeek, $endOfWeek]);
                    break;
                case 4:
                    $startOfMonth = Carbon::now('Asia/Kolkata')->startOfMonth();
                    $endOfMonth = Carbon::now('Asia/Kolkata')->endOfMonth();
                    $query->whereBetween('checkin_date', [$startOfMonth, $endOfMonth]);
                    break;
                case 5:
                    $startOfYear = Carbon::now('Asia/Kolkata')->startOfYear();
                    $endOfYear = Carbon::now('Asia/Kolkata')->endOfYear(); 
                    $query->whereBetween('checkin_date', [$startOfYear, $endOfYear]);
                    break;
               
            }
        }
        $query1 = $query->orderBy('created_at','DESC'); 
        
       
        $results = $queryFilter->builder($query1)->customFilter(new CommonMasterFilter)->paginate();
        return view('admin.party_booking._types', compact('results'))->render();
    }

    /**
    * Get Types by admin for ajax
    *cancel_booking
    */
    public function view(Request $request,QueryFilterContract $queryFilter,PartyBooking $booking)
    { 
        $page = trans('pages_names.types');
        $main_menu = 'room';
        $sub_menu = 'party-booking';
        // if($request->type == "pending")
        // {
        //     $sub_menu = 'pending-booking';
        // }
        // if($request->type == "checkin")
        // {
        //     $sub_menu = 'checkin-booking';
        // }
        // if($request->type == "cancelled")
        // {
        //     $sub_menu = 'cancelled-booking';
        // }
        // if($request->type == "completed")
        // {
        //     $sub_menu = 'completed-booking';
        // }
        $sub_menu_1 = '';
        $query = PartyBooking::where('booked_by',auth()->user()->id); 
        $checkinDate = Carbon::parse($booking->checkin_date);

        // Get the current date
        $currentDate = Carbon::now('Asia/kolkata');

        // Calculate the difference in days between the current date and the check-in date
        $daysDifference = $currentDate->diffInDays($checkinDate);
       $date_diff = $checkinDate->day - $currentDate->day;
        
        // dd($daysDifference);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();
        return view('admin.party_booking.view', compact('page', 'main_menu', 'sub_menu','sub_menu_1','booking','date_diff'))->render();
    }
    /**
    * Get Types by admin for ajax
    *
    */
    public function book_now(Request $request)
    {
        // dd($request->all());
        $now = Carbon::now('Asia/Kolkata');
        // Get the start and end of the current month
        $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s'); 
        $endOfMonth = $now->endOfMonth();
        // dd($endOfMonth);
        $user_id = auth()->user()->id;
        if(isset($request->user))
        { 
            $user_id = $request->user;
        }
        // Query to get bookings that overlap with the current month
        if(isset($request->id))
        {
            $totalDaysBooked = PartyBooking::whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
            ->where('user_id',$user_id)
            ->whereIn('status',[0,1,3])
            ->where('id', '!=',$request->id)
            ->get();
        }
        else{
            $totalDaysBooked = PartyBooking::whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
            ->where('user_id',$user_id)
            ->whereIn('status',[0,1,3])
            ->get();

        }
       
        $booking_count = 0;
        foreach($totalDaysBooked as $key=>$value)
        {
            $checkin = Carbon::parse($value->checkin_date);
            $checkout = Carbon::parse($value->checkout_date);
              $month_differ = $checkout->month - $checkin->month;
              if($month_differ > 0)
              { 
                $day_count = $endOfMonth->day - $checkin->day; 
                if($day_count == 0)
                {
                    $booking_count+=1;
                }
                else{
                    $booking_count+=$day_count;
                }
              }
              else{
                $booking_count+=$value->booking_count;
              }
        } 
        $checkinDatetime = Carbon::createFromFormat('Y-m-d', $request->from_date, 'Asia/Kolkata')->startOfDay()->format('Y-m-d H:i:s');
        $checkoutDatetime = Carbon::createFromFormat('Y-m-d', $request->to_date, 'Asia/Kolkata')->endOfDay()->format('Y-m-d H:i:s'); 

        $checkinDate = $request->input('from_date'); 
        $checkoutDate = $request->input('to_date'); 
        // Convert strings to Carbon instances
        $checkin = Carbon::createFromFormat('Y-m-d', $checkinDate);
        $checkout = Carbon::createFromFormat('Y-m-d', $checkoutDate);

        // Calculate the difference in days
        $differenceInDays = $checkin->diffInDays($checkout); 
        $booking_counts = $differenceInDays * $request->room;
        if($booking_counts > 10)
        {
            $response = [
                "status" => false,
                "message" => "Only you can able to make 10 bookings, Limit is reached"
            ];
            return response()->json($response);
        } 
        if(isset($request->id))
        {
            $bookings =  PartyBooking::find($request->id); 
        }
        else{
            $bookings =  new PartyBooking(); 
        } 
        $bookings->booking_id = time();
        $bookings->checkin_date = $checkinDatetime;
        $bookings->checkout_date = $checkoutDatetime;
        $bookings->no_of_rooms = $request->room;
        $bookings->no_of_guests = $request->guest;
        $bookings->guest_type = $request->guest_type;
        $bookings->booking_count = $booking_counts;
        $starting_count = $booking_count + 1; 
        $end_count = $booking_counts + $booking_count;  
        $tariff = Tariff::get();
        $price = 0; 
        foreach($tariff as $key=>$value)
        {
            for($i=$starting_count;$i<=$end_count;$i++)
            {
                
                if($value->day == $i)
                {
                    if($request->guest_type == "guest")
                    {

                        $price+=$value->rent_for_others;
                    }
                    else{ 
                        $price+=$value->rent_for_officers_family;
                    }
                }
            }
        } 
        
        $bookings->tariff = $price;
        $bookings->user_id = $user_id;
        $bookings->booked_by = auth()->user()->id;
        if(isset($request->id))
        {  
            $bookings->modified_by = $user_id;
            $timezone = 'Asia/Kolkata'; 
            // Get the current date and time in the specified timezone
            $currentDateTime = Carbon::now($timezone); 
            $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
            $bookings->modified_on = $formattedDateTime;
        }
        $bookings->save();
        $response = [
            "status" => true,
            "message" => "Booking Confirmed Successfully"
        ];
        return response()->json($response);

    }

    /**
    * Create Vehicle type
    *
    */
    public function check_availability(Request $request)
    {
        $user_id = auth()->user()->id;
        if(isset($request->user))
        { 
            $user_id = $request->user;
        } 
        // dd($request->id);
        if(isset($request->id))
        {
            $bookings = PartyBooking::where(function($query) use ($request) {
                $query->whereBetween('checkin_date', [$request->from_date, $request->to_date])
                      ->orWhereBetween('checkout_date', [$request->from_date, $request->to_date]);
            }) 
            ->whereIn('status',[0,1]) 
            ->where('id', '!=',$request->id)
            ->get(); 
        }
        else{
            $bookings = PartyBooking::whereBetween('checkin_date', [$request->from_date, $request->to_date])->orwhereBetween('checkout_date', [$request->from_date, $request->to_date])
                                ->whereIn('status',[0,1]) 
                                ->get();
        } 
        // if(count($bookings) == 0)
        // {
            $checkinDate = $request->input('from_date'); // e.g., '2024-06-21'
            $checkoutDate = $request->input('to_date'); // e.g., '2024-06-22'
    
            // Convert strings to Carbon instances
            $checkin = Carbon::createFromFormat('Y-m-d', $checkinDate);
            $checkout = Carbon::createFromFormat('Y-m-d', $checkoutDate);
    
            // Calculate the difference in days
            $differenceInDays = $checkin->diffInDays($checkout); 
            $booking_count = 0;
            $requested_count = $differenceInDays * $request->room;
            $booking_count = $differenceInDays * $request->room;
            if($booking_count > 10)
            {
                $response = [
                    "status" => false,
                    "message" => "Only you can able to make 10 bookings, Limit is reached"
                ];
                return response()->json($response);
            }
            else{ 
                $count = 0;
                $now = Carbon::now('Asia/Kolkata');
                $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s'); 
                $endOfMonth = $now->endOfMonth();
                $totalDaysBooked = PartyBooking::whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
                ->where('user_id',$user_id)
                ->whereIn('status',[0,1,3])
                ->get(); 
                $booked_count = 0;
                    foreach($totalDaysBooked as $key=>$value)
                    {
                        $checkin = Carbon::parse($value->checkin_date);
                        $checkout = Carbon::parse($value->checkout_date);
                        $month_differ = $checkout->month - $checkin->month;
                        if($month_differ > 0)
                        { 
                        $day_count = $endOfMonth->day - $checkin->day; 
                        if($day_count == 0)
                        {
                        $booked_count+=1;
                        }
                        else{
                        $booked_count+=$day_count;
                        }
                        }
                        else{
                        $booked_count+=$value->booking_count;
                        }
                    }
                $req_booked_count = $requested_count + $booked_count;
                if($booked_count == 10)
                {
                    $response = [
                        "status" => false,
                        "message" => "Month Quato exceeded"
                    ];
                    return response()->json($response);
                }
               
               
                if($req_booked_count > 10)
                {
                    $reduce_count = 10 - $booked_count; 
                    $response = [
                        "status" => false,
                        "message" => "only ".$reduce_count." booking is available in your month"
                    ];
                    return response()->json($response);

                }
                $count = 0;
                foreach($bookings as $key=>$value)
                { 
                    $count+=$value->no_of_rooms;
                }
                $room_tariff = Tariff::get();
                $room_count = $room_tariff[0]->total_rooms;
                if($count < $room_count)
                {
                    $reduce_count = $room_count - $count;
                    if($request->room <= $reduce_count)
                    {
                        $response = [
                            "status" => true,
                            "message" => "Room is Available. Please Proceed!"
                        ];
                        return response()->json($response);
                    }
                    else{
                        // dd("gfdgfd");
                        $response = [
                            "status" => false,
                            "message" => "only ".$reduce_count." room is available in your month quota"
                        ];
                        return response()->json($response);
                    }
                }
                else{
                    $response = [
                        "status" => false,
                        "message" => "No Rooms Available"
                    ];
                    return response()->json($response);
                } 
            }
         
           
        // } 
        return response()->json($response);
    }

 
    /**
    * Edit Vehicle type view
    *
    */
    public function edit(PartyBooking $booking)
    {   
        // dd($booking);
        $page = trans('pages_names.edit_type'); 
        // dd($type->is_taxi);
        // $admins = User::doesNotBelongToRole(RoleSlug::SUPER_ADMIN)->get();
        // $services = ServiceLocation::whereActive(true)->get();
        $main_menu = 'master';
        $sub_menu = 'types';
        $sub_menu_1 = '';
        $user = $this->user->belongsTorole(Role::USER)->get(); 
        return view('admin.party_booking.update', compact('page','main_menu', 'sub_menu','sub_menu_1','user','booking'));
    }


    /**
     * Update Vehicle type.
     *
     * @param \App\Http\Requests\Admin\VehicleTypes\CreateVehicleTypeRequest $request
     * @param App\Models\Admin\VehicleType $vehicle_type
     * @return \Illuminate\Http\JsonResponse
     * @response
     * {
     *"success": true,
     *"message": "success"
     *}
     */
    public function update(UpdateVehicleTypeRequest $request, VehicleType $vehicle_type)
    {
    if (auth()->user()->hasRole(!(Role::ADMIN))) {

        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('types')->with('warning', $message);
        }
    }
        // dd($request->all());
        $this->validateAdmin();
        $created_params = $request->only(['name', 'capacity','is_accept_share_ride','description','supported_vehicles','short_description','transport_type','icon_types_for']);

        if ($uploadedFile = $this->getValidatedUpload('icon', $request)) {
            $created_params['icon'] = $this->imageUploader->file($uploadedFile)
                ->saveVehicleTypeImage();
        }

        $created_params['is_taxi'] = $request->transport_type;
       
        $created_params['updated_by'] = auth()->user()->id;

        $vehicle_type->update($created_params);

        $message = trans('succes_messages.type_updated_succesfully');
        // clear the cache
        cache()->tags('vehilce_types')->flush();
        return redirect('types')->with('success', $message);
    }
    public function toggleStatus(VehicleType $vehicle_type)
    {
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('types')->with('warning', $message);
        }
        
        $status = $vehicle_type->active == 1 ? 0 : 1;
        $vehicle_type->update([
            'active' => $status
        ]);

        $message = trans('succes_messages.type_status_changed_succesfully');
        return redirect('types')->with('success', $message);
    }
    /**
     * Delete Vehicle type.
     *
     * @param App\Models\Admin\VehicleType $vehicle_type
     * @return \Illuminate\Http\JsonResponse
     * @response
     * {
     *"success": true,
     *"message": "success"
     *}
     */

    public function delete(VehicleType $vehicle_type)
    {
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('types')->with('warning', $message);
        }

        $vehicle_type->delete();

        $message = trans('succes_messages.vehicle_type_deleted_succesfully');
        return $message;
    }
    public function cancel_booking(PartyBooking $booking)
    {
         $booking = PartyBooking::find($booking->id);
         $booking->status = 2; 
         $booking->cancelled_by = auth()->user()->id;
         $timezone = 'Asia/Kolkata'; 
         // Get the current date and time in the specified timezone
         $currentDateTime = Carbon::now($timezone); 
         $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
         $booking->cancelled_on = $formattedDateTime;
         $booking->save();
         $message = [
            "status" => true,
            "message" => "Booking Cancelled Successfully",
         ];
         return response()->json($message);
    }
    public function confirm_checkin(PartyBooking $booking,Request $request)
    {
        $invoice = new Invoice();
        $invoice_number = Invoice::orderBy('created_at', 'DESC')->pluck('invoice_number')->first();

        if ($invoice_number) {
            // Extract the numeric part from the userid
            preg_match('/(\d+)$/', $invoice_number, $matches);
            $numberPart = isset($matches[1]) ? intval($matches[1]) + 1 : 500001; // Increment or default to 1001 if not found
            $invoice_number = str_pad($numberPart, 6, '0', STR_PAD_LEFT); // Ensure the number part is at least 4 digits
        } else {
            $invoice_number = "500001"; // Default userid
        } 
        $invoice->invoice_number =  $invoice_number;
        $invoice->booking_id =  $booking->id;
        $invoice->customer_id =  $booking->user_id;
        $now = Carbon::now('Asia/Kolkata');
        $invoice->issue_date =  $now->format("Y-m-d");
        $invoice->due_date =  $booking->checkin_date;
        $invoice->total_amount =  $booking->tariff; 
        if($request->amount)
        {  
            $invoice->initial_price = $request->price;
            $invoice->initial_price_status = 1; 
            $invoice->amount_need_to_paid = $booking->tariff - $request->price; 
        } 
       $invoice->type =  2;
       $invoice->status =  1;
       $invoice->save(); 
       $booking->status =  1;
       $booking->is_paid =  0;
       $booking->save();
        $response = [
        "status" => true,
        "message" => "CheckIn Confirmed Successfully",
        ];
        return response()->json($response);
    } 
    public function confirm_checkout(PartyBooking $booking,Request $request)
    {  
        $booking->status =  3;
        $booking->is_paid =  1;
        $booking->save();
        $response = [
        "status" => true,
        "message" => "Checkout Confirmed Successfully",
        ];
        return response()->json($response);
    } 
    /**
    * Get Types by admin for ajax
    *cancel_booking
    */
    public function view_invoice(Request $request,QueryFilterContract $queryFilter,PartyBooking $booking)
    { 
        $page = trans('pages_names.types');
        $main_menu = 'master';
        $sub_menu = 'types';
        $sub_menu_1 = '';
        $query = PartyBooking::where('booked_by',auth()->user()->id); 
        $invoice = Invoice::where('booking_id',$booking->id)->first(); 
        $checkinDate = Carbon::parse($booking->checkin_date);

        // Get the current date
        $currentDate = Carbon::now('Asia/kolkata');

        // Calculate the difference in days between the current date and the check-in date
        $daysDifference = $currentDate->diffInDays($checkinDate);
       $date_diff = $checkinDate->day - $currentDate->day;
        
        // dd($daysDifference);
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

        // dd($booking->booked_price);
        return view('admin.party_booking.invoice', compact('page', 'main_menu', 'sub_menu','sub_menu_1','booking','date_diff','invoice'))->render();
    }
    public function export(PartyBooking $booking)
    {     
        // dd($booking_guest_details);
        $invoice = Invoice::where('booking_id',$booking->id)->first();
        $user_details = User::where('id',$booking->user_id)->first();
        // dd($booking);
        $data = [
            'booking' => $booking->toArray(),
            'invoice' => $invoice->toArray(), 
            'user_details' => $user_details->toArray()
        ];
        // print_r($data);
        // exit;
        $pdf = PDF::loadView('pdf.party.invoice', $data);  
        return $pdf->download('user.pdf');
    }
}
