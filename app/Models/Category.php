<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;

    protected $fillable = [
        'category_name',
        'layout_detail_path'
    ];

    public function articles() : HasMany
    {
        return $this->hasMany(Article::class, 'category_id');
    }
}
