<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostItem;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_container_id',
        'author_id',
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

    public function container()
    {
        return $this->belongsTo('App\Models\PostContainer', 'post_container_id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }

    public static function boot()
    {
        parent::boot();

        // self::deleting(function($model){
        //     $model->groups()->detach();
        //     $model->widgets()->delete();
        // });
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

        $ordering = 0;

        foreach ($saveData as $postItemId => $postData) {
            foreach ($postData as $widgetId => $widget) {

                $params = [];
                foreach ($widget as $paramId => $param) {
                    $params[$paramId] = $param;
                }

                $newWidgets[] = new PostItem([
                    'widget_id' => $widgetId,
                    'ordering' => $ordering,
                    'parameters' => $params
                ]);
            }

            $ordering++;
        }

        if ($newWidgets !== []) {
            $this->widgets()->saveMany($newWidgets);
        }
    }
}
