<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasFactory;

    protected $table = "tb_article_category";

    public function children()
    {
        return $this->hasMany(ArticleCategory::class, 'category_id','parent_category_id');
    }

    public function parent()
    {
        return $this->belongsTo(ArticleCategory::class, 'parent_category_id','category_id');
    }
}
