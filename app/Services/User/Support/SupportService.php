<?php

namespace App\Services\User\Support;

use App\Models\Support;
use App\Services\Base\BaseService;

class SupportService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Support::class);
    }
}
