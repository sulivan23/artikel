<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{
    use HasFactory;

    protected $table = "tb_followers";

    public function followers()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function following()
    {
        return $this->hasOne(User::class,'id', 'follower_user_id');
    }
}
