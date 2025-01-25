<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_requests';
    protected $primaryKey = 'payment_request_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    // Generate
    public static function generateReferenceCode()
    {
        $lastData = PaymentRequest::where('reference_code', 'LIKE', '%PY/'.date('y').'/'.date('m').'/'.'%')->orderBy('reference_code', 'DESC')->first();
        if($lastData)
        {
            $exData = explode('PY/'.date('y').'/'.date('m').'/', $lastData->reference_code);
            $newNumber = ((int) $exData[1] + 1);

            $refCode = 'PY/'.date('y').'/'.date('m').'/'.str_pad($newNumber, 3, "0", STR_PAD_LEFT);
        }
        else
        {
            $refCode = 'PY/'.date('y').'/'.date('m').'/001';
        }
        
        return $refCode;
    }

    // Relation
    public function re_trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
    public function re_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function re_has_invoices()
    {
        return $this->hasMany(Invoice::class, 'payment_request_id');
    }
}
