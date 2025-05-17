<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Recruitment;
use App\Services\ApplicationService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function index(Recruitment $recruitment)
    {
        $applications = $this->applicationService->getAllForRecruitment($recruitment);
        
        return view('admin.applications.index', [
            'recruitment' => $recruitment,
            'applications' => $applications
        ]);
    }

    public function updateStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        $application = $this->applicationService->updateStatus($application, $validated['status']);

        return response()->json([
            'message' => 'Statut mis à jour avec succès',
            'application' => $application
        ]);
    }

    public function destroy(Application $application)
    {
        $this->applicationService->delete($application);

        return response()->json([
            'message' => 'Candidature supprimée avec succès'
        ]);
    }
}
