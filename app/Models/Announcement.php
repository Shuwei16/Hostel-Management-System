<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $table = 'announcements';
    protected $primaryKey = 'announcement_id';
    protected $fillable = ['title', 'content', 'image', 'announced_block', 'announced_gender', 'publicity'];

    public  function comment()
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }
}
