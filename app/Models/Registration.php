<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    protected $primaryKey = 'registration_id';
    protected $fillable = ['student_id', 'semester_id', 'room_id', 'registration_type', 'payment_due_date', 'withdrawal_due_date', 'check_in_date', 'check_out_date', 'status'];

    public  function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    
    public  function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public  function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public  function payment()
    {
        return $this->hasOne(Payment::class, 'payment_id');
    }

}
