<?php

namespace App\Http\Controllers;

use App\Models\ProgressLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgressLogController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index(): JsonResponse
    {

        $data = ProgressLog::where('user_id', $this->getLoggedUser()->id)
            ->with('training')
            ->get();
        // Logic to retrieve progress logs
        return new JsonResponse([
            'success' => true,
            'message' => 'Progress logs retrieved successfully.',
            'progress_logs' => $data
        ], 200);
    }
}
