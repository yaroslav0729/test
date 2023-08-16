<?php

namespace App\Models;

use Illuminate\Http\Request;
use Spatie\LaravelSettings\Settings;

class FoodPackSettings extends Settings
{
    public string $status;

    public function update(Request $request)
    {
        $this->status = $request->get('status');
        $this->save();
    }

    public static function getStatus(): string
    {
        return (new FoodPackSettings())->status;
    }

    public static function group(): string
    {
        return 'food-pack';
    }
}
