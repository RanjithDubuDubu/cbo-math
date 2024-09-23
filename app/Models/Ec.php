<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ec extends Model
{
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ec';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plf_id', 'panchayat', 'shg_id', 'shg_member_id', 'from_date', 'to_date', 'village_name', 'plf_name', 'shg_name', 'shg_member_name', 'created_at', 'updated_at'
    ];

    public function PanchayatDetails()
    {
        return $this->belongsTo(Panchayat::class, 'panchayat', 'id');
    }
}
