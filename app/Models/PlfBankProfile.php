<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlfBankProfile extends Model
{
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plf_bank_profile';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name', 'bank_id', 'branch_name', 'account_number', 'acc_type', 'acc_opening_date', 'passbook_file', 'is_primiary_account', 'status', 'created_at', 'updated_at','plf_id' 
    ];

    public function Bankdetails()
    {
        return $this->belongsTo(Bankdetails::class, 'bank_id', 'id');
    }
    public function profile()
    {
        return $this->belongsTo(PlfProfile::class, 'plf_id', 'id');
    }
}
