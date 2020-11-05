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

    protected $casts = [
        'parameters' => 'array',
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

    public function renderTemplateParametersForm()
    {
        if ($this->template) {
            return view('templates.form.' . $this->template, [
                'parameters' => $this->parameters
            ]);
        } else {
            return null;
        }
    }

    public function renderTemplate()
    {
        if ($this->template) {
            return view('templates.presentation.' . $this->template, [
                'parameters' => $this->parameters
            ]);
        } else {
            return null;
        }
    }
}
