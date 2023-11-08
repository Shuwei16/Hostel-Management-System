<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingApplication extends Model
{
    use HasFactory;
    protected $table = 'parking_applications';
    protected $primaryKey = 'parking_application_id';
    protected $fillable = ['student_id', 'make', 'model', 'year', 'color', 'plate_no', 'app_date', 'status', 'note'];

    public  function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
