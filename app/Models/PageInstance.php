<?php

namespace App\Models;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageInstance extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'author_id',
        'name',
        'slug',
        'title',
        'description',
        'keywords',
        'template',
        'parameters',
    ];

    public function page()
    {
        return $this->belongsTo('App\Models\Page', 'page_id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }

    public function getTemplateNameAttribute()
    {
        return Template::getLabel($this->template);
    }
}
