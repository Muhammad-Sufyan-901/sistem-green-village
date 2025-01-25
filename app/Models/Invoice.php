<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invoices';
    protected $primaryKey = 'invoice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    // Generate
    public static function generateReferenceCode()
    {
        $lastData = Invoice::where('reference_code', 'LIKE', '%INV/'.date('y').'/'.date('m').'/'.'%')->orderBy('reference_code', 'DESC')->first();
        if($lastData)
        {
            $exData = explode('INV/'.date('y').'/'.date('m').'/', $lastData->reference_code);
            $newNumber = ((int) $exData[1] + 1);

            $refCode = 'INV/'.date('y').'/'.date('m').'/'.str_pad($newNumber, 3, "0", STR_PAD_LEFT);
        }
        else
        {
            $refCode = 'INV/'.date('y').'/'.date('m').'/001';
        }
        
        return $refCode;
    }

    // Relation
    public function re_payment_request()
    {
        return $this->belongsTo(PaymentRequest::class, 'payment_request_id');
    }
    public function re_created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}
