<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shgmember extends Model
{   
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shg_members';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'shg_id', 'member_id', 'member_name', 'father_name', 'age', 'dob', 'gender', 'community', 'religion', 'vulnerability', 'vulnerability_categiryt', 'education', 'occupation', 'worker_code', 'msme_reg_number', 'pan_number', 'aadhar_number', 'smart_card', 'contact', 'role', 'monthly_savings', 'is_vrf_received', 'vrf_amount', 'is_insurance_registered', 'insurance_type', 'last_expiry_date', 'islivelihood', 'livelihood_activities', 'is_esharm', 'annual_income', 'pip_category', 'pip_number', 'ifsc', 'account_type', 'account_number', 'branch_name', 'bank_name', 'account_status', 'family_member_count', 'annual_income_family', 'is_local_representative', 'local_representative_position', 'created_at', 'updated_at', 'is_active', 'reason', 'updated_by', 'vrf_date'
    ];

    public function PanchayatDetails()
    {
        return $this->belongsTo(Panchayat::class, 'panchayat', 'id');
    }
}
