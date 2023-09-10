<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    protected $fillable = ['registration_id', 'receipt_no', 'amount', 'payment_method'];

    public  function registration()
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }
}
