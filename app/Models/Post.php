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
        return $this->hasMany('App\Models\PostItem')->orderBy('ordering');
    }

    public function getGroupIdsAttribute()
    {
        return $this->groups->pluck('id')->toArray();
    }

    public function parseWidgets($widgets)
    {
        $widgets = json_decode($widgets);
        $newWidgets = [];

        $this->removeOldWidgets($widgets);

        foreach ($widgets as $widget) {
            if ($widget->id === 'new') {
                $newWidgets[] = new PostItem([
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
            $this->widgets()->saveMany($newWidgets);
        }

        return true;
    }

    protected function removeOldWidgets($widgets)
    {
        $currentIds = [];
        $newIds = [];
        $deletedIds = [];

        foreach ($this->widgets as $widget) {
            $currentIds[] = $widget->id;   
        }

        foreach ($widgets as $widget) {
            $newIds[] = $widget->id;   
        }

        foreach ($currentIds as $id) {
            if (!in_array($id, $newIds)) {
                $deletedIds[] = $id;
            }
        }

        if (count($deletedIds)) {
            $postItems = PostItem::whereIn('id', $deletedIds)->delete();
        }
    }
}
