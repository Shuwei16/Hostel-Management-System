<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    protected $fillable = ['user_id', 'announcement_id', 'content'];

    public  function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public  function announcement()
    {
        return $this->belongsTo(Announcement::class, 'announcement_id');
    }
}
