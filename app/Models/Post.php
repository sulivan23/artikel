<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = "tb_article";

    protected $fillable = [
        'article_id',
        'judul_artikel',
        'category_id',
        'author_id',
        'tags',      
        'walpaper',
        'content',
        'views_count',
        'likes_count',
        'status',
        'slug',
        'publish_date',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->hasOne(User::class,'id','author_id');
    }

    public function attachments()
    {
        return $this->hasMany(ArticleAttachments::class,'article_id','article_id');
    }

    public function category()
    {
        return $this->hasOne(ArticleCategory::class,'category_id','category_id');
    }
}
