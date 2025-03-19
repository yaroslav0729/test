<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upsell extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'active',
        'project_name',
        'program_name',
        'campaign_category_id'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'price' => 'float',
        'active' => 'boolean',
        'project_name' => 'string',
        'program_name' => 'string',
        'campaign_category_id' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(CampaignCategory::class, 'campaign_category_id');
    }
}
