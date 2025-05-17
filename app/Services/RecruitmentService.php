<?php

namespace App\Services;

use App\Models\Recruitment;
use Illuminate\Support\Facades\Storage;

class RecruitmentService
{
    public function getAll()
    {
        return Recruitment::with('country')->latest()->get();
    }

    public function create(array $data)
    {
        if (isset($data['file_pdf']) && $data['file_pdf']->isValid()) {
            $path = $data['file_pdf']->store('recruitments', 'public');
            $data['file_pdf'] = $path;
        }

        return Recruitment::create($data);
    }

    public function update(Recruitment $recruitment, array $data)
    {
        if (isset($data['file_pdf']) && $data['file_pdf']->isValid()) {
            // Delete old file if exists
            if ($recruitment->file_pdf) {
                Storage::disk('public')->delete($recruitment->file_pdf);
            }
            
            $path = $data['file_pdf']->store('recruitments', 'public');
            $data['file_pdf'] = $path;
        }

        $recruitment->update($data);
        return $recruitment;
    }

    public function delete(Recruitment $recruitment)
    {
        if ($recruitment->file_pdf) {
            Storage::disk('public')->delete($recruitment->file_pdf);
        }
        
        return $recruitment->delete();
    }
}
