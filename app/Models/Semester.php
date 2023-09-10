<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $table = 'semesters';
    protected $primaryKey = 'semester_id';
    protected $fillable = ['semester_name', 'start_date', 'end_date', 'withdrawal_date', 'payment_due_date', 'earliest_check_in_date', 'latest_check_out_date', 'price', 'new_reg_open_date', 'new_reg_close_date', 'extension_reg_open_date', 'extension_reg_close_date'];

    public  function registration()
    {
        return $this->hasMany(Registration::class, 'registration_id');
    }
}
