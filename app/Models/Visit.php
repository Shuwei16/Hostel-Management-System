<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $table = 'visits';
    protected $primaryKey = 'visit_id';
    protected $fillable = ['visitor_reg_id', 'check_in_time', 'check_out_time'];

    public  function visitorRegistration()
    {
        return $this->belongsTo(VisitorRegistration::class, 'visitor_reg_id');
    }
}
