<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeBearers extends Model
{
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'office_bearers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'ec_member_id', 'from_date', 'to_date', 'signatory', 'office_type', 'created_at', 'updated_at'
    ];

    public function ecmember()
    {
        return $this->belongsTo(Ec::class, 'ec_member_id', 'id');
    }
}
