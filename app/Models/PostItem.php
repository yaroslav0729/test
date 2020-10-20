<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return view('widgets.' . $this->widget_id, ['parameters' => $this->parameters]);
    }
}
