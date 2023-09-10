<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSlot extends Model
{
    use HasFactory;
    protected $table = 'maintenance_slots';
    protected $primaryKey = 'slot_id';
    protected $fillable = ['date','time', 'status'];

    public  function maintenanceBooking()
    {
        return $this->hasOne(MaintenanceBooking::class, 'maintenance_booking_id');
    }
}
