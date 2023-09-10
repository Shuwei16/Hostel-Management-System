<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    protected $fillable = ['student_id', 'content'];

    public  function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public  function announcement()
    {
        return $this->belongsTo(Announcement::class, 'announcement_id');
    }
}
