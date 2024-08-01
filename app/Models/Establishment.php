<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Establishment extends Model
{
    use HasFactory;
    protected $primaryKey = 'est_id';

    protected $fillable = [
        'est_name',
        'est_street',
        'region_id',
        'province_id',
        'city_id',
        'barangay_id',
        'est_nature',
        'est_products',
        'est_class',
        'est_tin',
        'est_sss',
        'est_payment',
        'est_yearImplemented',
        'est_numworkMale',
        'est_numworkFemale',
        'est_numworkManager',
        'est_numworkSupervisor',
        'est_numworkRanks',
        'est_numworkTotal',
        'est_permit',
        'est_govId',
        'est_owner',
        'est_designation',
        'est_fax',
        'est_contactNum',
        'est_email',
        'est_acknowledgement',
        'est_certIssuance',
        'est_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'est_id');
    }
}
