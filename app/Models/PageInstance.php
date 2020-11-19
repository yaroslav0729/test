<?php

namespace App\Models;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;

class PageInstance extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'author_id',
        'name',
        'slug',
        'preview_text',
        'preview_img',
        'title',
        'description',
        'keywords',
        'template',
        'parameters',
        'html'
    ];

    protected $casts = [
        'parameters' => 'array',
    ];

    public function page()
    {
        return $this->belongsTo('App\Models\Page', 'page_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_page');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }

    public function getPublishedAtAttribute()
    {
        return $this->page->published_at;
    }

    public function getCategoryIdsAttribute()
    {
        return $this->categories->pluck('id')->toArray();
    }

    public function getTemplateNameAttribute()
    {
        return Template::getLabel($this->template);
    }

    public function getIsPublishedAttribute()
    {
        return ($this->page->status === \App\Models\Page::PAGE_STATUS_PUBLICHED);
    }

    public function scopePublished($query)
    {
        return $query->whereHas('page', function(Builder $queryPage) {
            $queryPage->where('status', Page::PAGE_STATUS_PUBLICHED);
        });
    }

    public function scopeActual($query)
    {
        return $query->where('actual', true);
    }

    public function renderTemplateParametersForm()
    {
        if ($this->template) {
            return view('templates.form.' . $this->template, [
                'parameters' => $this->parameters,
            ]);
        } else {
            return null;
        }
    }

    public function renderTemplate()
    {
        if ($this->template) {
            return view('templates.presentation.' . $this->template, [
                'parameters' => $this->parameters,
                'pageInstance' => $this
            ]);
        } else {
            return null;
        }
    }
}
