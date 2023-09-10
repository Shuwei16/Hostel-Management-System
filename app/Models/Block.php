<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    protected $table = 'blocks';
    protected $primaryKey = 'block_id';
    protected $fillable = ['block_name', 'gender'];

    public  function room()
    {
        return $this->hasMany(Room::class, 'room_id');
    }
}
