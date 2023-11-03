<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    protected $fillable = ['user_id', 'ic', 'student_card_no', 'resident_id', 'contact_no', 'gender', 'race', 'citizenship', 'address', 'emergency_contact_name', 'emergency_contact_no'];

    public  function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public  function registration()
    {
        return $this->hasMany(Registration::class, 'registration_id');
    }

    public  function maintenanceBooking()
    {
        return $this->hasMany(MaintenanceBooking::class, 'maintenance_booking_id');
    }

    public  function parkingApplication()
    {
        return $this->hasMany(ParkingApplication::class, 'parking_app_id');
    }

    public  function visitorRegistration()
    {
        return $this->hasMany(VisitorRegistration::class, 'visitor_reg_id');
    }
}
