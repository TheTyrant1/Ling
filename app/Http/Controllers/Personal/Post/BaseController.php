<?php

namespace App\Http\Controllers\Personal\Post;

use App\Http\Controllers\Controller;
use App\Services\Post\StoreService;
use App\Services\Post\UpdateService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests;
    public $storeService;
    public $updateService;

    public function __construct(StoreService $storeService, UpdateService $updateService)
    {
        $this->storeService = $storeService;
        $this->updateService = $updateService;
    }
}
