<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panchayat extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'villages';
   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
     'villagename', 'villagecode', 'blockname', 'blockcode', 'districtname', 'districtcode', 'bc_id', 'shg_circle_flag', 'sng_circle_no', 'latitude', 'longitude', 'address', 'location_image', 'location_image1', 'building_type', 'building_type1', 'location_image2', 'location_image3'
   ];

   public function PanchayatDetails()
   {
       return $this->hasMany(Panchayat::class, 'blockcode', 'blockcode');
   }
}
