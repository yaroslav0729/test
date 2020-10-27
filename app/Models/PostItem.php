<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Widget;
use App\Models\WidgetParameters;

class PostItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'widget_id',
        'ordering',
        'parameters',
    ];

    protected $casts = [
        'parameters' => 'array',
    ];

    public function render()
    {
        return view('widgets.' . $this->widget_id, [
            'parameters' => $this->parameters
        ]);
    }

    public function getLabelAttribute()
    {
        return Widget::WIDGET_LABELS[$this->widget_id];
    }

    public function getAvailableParametersAttribute()
    {
        return Widget::AVAILABLE_PARAMETERS[$this->widget_id];
    }

    public function getSavedParametersAttribute()
    {
        $savedParams = Widget::AVAILABLE_PARAMETERS[$this->widget_id];

        foreach ($savedParams as $key => $param) {

            if (array_key_exists($param['name'], $this->parameters)) {
                $savedParams[$key]['value'] = $this->parameters[$param['name']];
                unset($savedParams[$key]['default']);
            } else {
                $savedParams[$key]['value'] = null;
            }
        }

        return $savedParams;
    }
}
