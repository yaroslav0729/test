<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostItem;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'title',
        'description',
        'keywords',
    ];

    public function groups()
    {
        return $this->belongsToMany('App\Models\PostGroup');
    }

    public function widgets()
    {
        return $this->hasMany('App\Models\PostItem');
    }

    public function getGroupIdsAttribute()
    {
        return $this->groups->pluck('id')->toArray();
    }

    public function parseWidgets($widgets)
    {
        $widgets = json_decode($widgets);
        $newWidgets = [];

        foreach ($widgets as $widget) {
            if ($widget->id === 'new') {
                $newWidgets = new PostItem([
                    'widget_id' => $widget->widget_id,
                    'ordering' => $widget->ordering,
                    'parameters' => $widget->parameters
                ]);    
            } else {
                $postItem = PostItem::where('id', $widget->id)->firstOrFail();
                $postItem->ordering = $widget->ordering;
                $postItem->parameters = $widget->parameters;
                $postItem->save();
            }
        }

        if ($newWidgets !== []) {
            $this->widgets()->save($newWidgets);
        }

        return true;
    }
}
