<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    protected $primaryKey = 'room_id';
    protected $fillable = ['block_id', 'room_code', 'room_no', 'floor_no', 'occupied_slots', 'race_restrictions'];

    public  function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }

    public  function registration()
    {
        return $this->hasMany(Registration::class, 'registration_id');
    }
}
