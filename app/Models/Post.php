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

    public static function boot()
    {
        parent::boot();

        self::deleting(function($model){
            $model->groups()->detach();
            $model->widgets()->delete();
        });
    }

    public function getGroupIdsAttribute()
    {
        return $this->groups->pluck('id')->toArray();
    }

    public function parseWidgets($request)
    {
        $data = $request->all();
        $saveData = [];
        $newWidgets = [];

        foreach ($data as $paramKey => $param) {
            if (strpos($paramKey, 'widget_param_') !== false) {

                $postData = substr($paramKey, strlen('widget_param_'));
                $postData = explode('_', $postData);

                list($postItemId, $widgetId, $paramId) = $postData;

                $saveData[$postItemId][$widgetId][$paramId] = $param; 
            }    
        }

        foreach ($saveData as $postItemId => $postData) {
            foreach ($postData as $widgetId => $widget) {
                $postItem = PostItem::where('id', $postItemId)->
                                    where('widget_id', $widgetId)->first();

                $params = [];
                foreach ($widget as $paramId => $param) {
                    $params[$paramId] = $param;
                }

                if (!$postItem) {
                    $newWidgets[] = new PostItem([
                        'widget_id' => $widgetId,
                        'ordering' => 1,
                        'parameters' => $params
                    ]);
                } else {
                    $postItem->parameters = $params;
                    $postItem->save();
                }
            }
        }

        if ($newWidgets !== []) {
            $this->widgets()->saveMany($newWidgets);
        }
    }

    public function parseWidgetsOld($widgets)
    {
        $widgets = json_decode($widgets);
        $newWidgets = [];

        $this->removeOldWidgets($widgets);

        foreach ($widgets as $widget) {

            $this->parseSavedParameters($widget->saved_parameters);

            if (strpos($widget->id, 'new_') !== false) {
                $newWidgets[] = new PostItem([
                    'widget_id' => $widget->widget_id,
                    'ordering' => $widget->ordering,
                    'parameters' => $this->parseSavedParameters($widget->saved_parameters)
                ]);    
            } else {
                $postItem = PostItem::where('id', $widget->id)->firstOrFail();
                $postItem->ordering = $widget->ordering;
                $postItem->parameters = $this->parseSavedParameters($widget->saved_parameters);
                $postItem->save();
            }
        }

        if ($newWidgets !== []) {
            $this->widgets()->saveMany($newWidgets);
        }

        return true;
    }

    protected function parseSavedParameters($savedParams)
    {
        $parameters = [];

        foreach ($savedParams as $sParam) {
            $parameters[$sParam->name] = $sParam->value;
        }

        return $parameters;
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
