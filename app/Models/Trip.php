<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trip';
    protected $primaryKey = 'trip_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    // Relation
    public function re_created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
    public function re_driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'user_id');
    }
    public function re_type_trip()
    {
        return $this->belongsTo(TypeTrip::class, 'type_trip_id');
    }
    public function re_has_payment_request()
    {
        return $this->hasMany(PaymentRequest::class, 'trip_id');
    }
}
