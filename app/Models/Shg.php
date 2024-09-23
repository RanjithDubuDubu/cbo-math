<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shg extends Model
{
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shg';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'block', 'panchayat', 'vo_name', 'vo_id', 'vo_code', 'fomation_date', 'promoted_by', 'last_office_bearer_elected_date', 'ob_election_tenure', 'is_vo_registered', 'register_no', 'register_act', 'registered_copy', 'total_shg', 'status', 'created_at', 'updated_at'  
    ];

    public function PanchayatDetails()
    {
        return $this->belongsTo(Panchayat::class, 'panchayat', 'id');
    }
}
