<?php

namespace App\Services;

use App\Models\BlackList;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlackListService extends AbstractModelService
{
    public function __construct(BlackList $blackList)
    {
        $this->model = $blackList;
    }

    public function addIp(Request $request): bool
    {
        return $this->create([
            'ip' => $request->get('ip')
        ]);
    }

    public function isBlackIp(string $ip): bool
    {
        return $this->model->where("ip", $ip)->exists();
    }
}
