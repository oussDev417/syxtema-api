<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Recruitment;
use Illuminate\Support\Facades\Storage;

class ApplicationService
{
    public function create(Recruitment $recruitment, array $data)
    {
        // Handle CV upload
        if (isset($data['cv']) && $data['cv']->isValid()) {
            $cvPath = $data['cv']->store('applications/cv', 'public');
            $data['cv'] = $cvPath;
        }

        // Handle cover letter upload
        if (isset($data['cover_letter']) && $data['cover_letter']->isValid()) {
            $letterPath = $data['cover_letter']->store('applications/letters', 'public');
            $data['cover_letter'] = $letterPath;
        }

        $data['recruitment_id'] = $recruitment->id;
        return Application::create($data);
    }

    public function getAllForRecruitment(Recruitment $recruitment)
    {
        return $recruitment->applications()->latest()->get();
    }

    public function delete(Application $application)
    {
        // Delete associated files
        if ($application->cv) {
            Storage::disk('public')->delete($application->cv);
        }
        if ($application->cover_letter) {
            Storage::disk('public')->delete($application->cover_letter);
        }

        return $application->delete();
    }
}
