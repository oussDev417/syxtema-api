<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Recruitment;
use App\Services\ApplicationService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApplicationRequest;

class ApplicationController extends Controller
{
    protected $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function store(StoreApplicationRequest $request, $recruitmentId)
    {
        $recruitment = Recruitment::findOrFail($recruitmentId);
        $application = $this->applicationService->create($recruitment, $request->validated());
        
        return response()->json([
            'message' => 'Candidature soumise avec succès',
            'application' => $application
        ], 201);
    }

    public function index($recruitmentId)
    {
        $recruitment = Recruitment::findOrFail($recruitmentId);
        $applications = $this->applicationService->getAllForRecruitment($recruitment);
        
        return response()->json($applications);
    }
}
