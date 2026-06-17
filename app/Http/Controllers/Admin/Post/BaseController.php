<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Services\Post\StoreService;
use App\Services\Post\UpdateService;


class BaseController extends Controller
{
    public $storeService;
    public $updateService;

    public function __construct(StoreService $storeService, UpdateService $updateService)
    {
        $this->storeService = $storeService;
        $this->updateService = $updateService;
    }
}
