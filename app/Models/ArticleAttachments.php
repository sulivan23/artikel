<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleAttachments extends Model
{
    use HasFactory;

    protected $table = 'tb_article_attachments';

    protected $fillable = [
        'article_id',
        'attachment_url',
        'attachment_type',
        'attachment_size',
        'title',
        'alt',
        'caption',
        'created_at',
        'updated_at',
    ];

    public function article()
    {
        $this->belongsTo(Post::class,'article_id','article_id');
    }
}
