<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    use HasFactory;

    const TYPE_301 = 301;
    const TYPE_302 = 302;

    const TYPES = [
        self::TYPE_301 => '301 - permanently redirect',
        self::TYPE_302 => '302 - temporary redirect',
    ];

    protected $fillable = [
        'url_from',
        'url_to',
        'type',
    ];

    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model->url_from = \App\Helpers\StrHelper::deleteTrailingSlash($model->url_from);
            $model->url_to = \App\Helpers\StrHelper::deleteTrailingSlash($model->url_to);
        });
    }

    public static function slugHasRedirect($slug)
    {
        $redirects = self::where('url_from', $slug)->get();

        return count($redirects) ? true : false;
    }

    public static function redirectFromSlug($slug)
    {
        $redirect = self::where('url_from', $slug)->firstOrFail();

        return redirect($redirect->url_to, $redirect->type === 301 ? 301 : 302);
    }

}
