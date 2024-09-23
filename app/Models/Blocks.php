<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blocks extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blocks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'blockname', 'bmm', 'bc_smib', 'bc_cb_skill', 'bc_mis', 'bc_pc', 'bc_fi2', 'bc_fi', 'bc_lh', 'bc_lp', 'districtcode', 'blockcode', 'latitude', 'longitude', 'created_at', 'updated_at', 'bc_skill', 'bc_ibcb'
    ];

    public function BlockDetails()
   {
       return $this->hasMany(Panchayat::class, 'blockcode', 'blockcode');
   }
}
