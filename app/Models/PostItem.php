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

    public function renderWithElements()
    {
        return view('widgets.widget_elements', [
            'itemId' => $this->id,
            'widgetId' => $this->widget_id,
            //'widgetHtml' => $this->render(),
            'availableParameters' =>  WidgetParameters::AVAILABLE_PARAMETERS[$this->widget_id],
            'parameters' => $this->parameters
        ]);
    }

    public function getLabelAttribute()
    {
        return Widget::WIDGET_LABELS[$this->widget_id];
    }

    public function getAvailableParametersAttribute()
    {
        return WidgetParameters::AVAILABLE_PARAMETERS[$this->widget_id];
    }
}
