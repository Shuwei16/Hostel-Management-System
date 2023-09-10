<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceBooking extends Model
{
    use HasFactory;
    protected $table = 'maintenance_bookings';
    protected $primaryKey = 'maintenance_booking_id';
    protected $fillable = ['slot_id', 'student_id', 'maintenance_type', 'description', 'status'];

    public  function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public  function slot()
    {
        return $this->belongsTo(MaintenanceSlots::class, 'slot_id');
    }
}
