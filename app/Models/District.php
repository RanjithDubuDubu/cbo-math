<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'district';
   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'districtcode', 'districtname', 'latitude', 'longitude', 'apo_ibcb', 'apo_fi', 'apo_pc', 'apo_sp', 'apo_lp', 'apo_aa', 'apo_nulm', 'pd', 'apo_smib', 'apo_cb_skill', 'apo_mis', 'apo'
   ];

   
}
