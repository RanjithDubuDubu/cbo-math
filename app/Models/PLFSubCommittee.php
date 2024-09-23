<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PLFSubCommittee extends Model
{
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plf_sub_committee';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subcommittee_name', 'formation_date', 'member_id', 'doj','created_at', 'updated_at'
    ];

    public function PanchayatDetails()
    {
        return $this->belongsTo(Panchayat::class, 'panchayat', 'id');
    }
}
