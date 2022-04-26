<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $table ="tb_comments";

    public function article()
    {
        return $this->hasOne(Post::class,'article_id','article_id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
