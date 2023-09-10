<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorRegistration extends Model
{
    use HasFactory;
    protected $table = 'visitor_registrations';
    protected $primaryKey = 'visitor_reg_id';
    protected $fillable = ['student_id', 'visitor_name', 'visit_purpose', 'visit_date', 'visit_time', 'duration', 'qr_code', 'status', 'note'];

    public  function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public  function vist()
    {
        return $this->hasOne(Visit::class, 'visit_id');
    }
}
