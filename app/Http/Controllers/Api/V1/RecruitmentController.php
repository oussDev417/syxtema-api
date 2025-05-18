<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Recruitment;
use App\Http\Resources\RecruitmentResource;
use App\Http\Resources\RecruitmentCollection;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    public function index()
    {
        $recruitments = Recruitment::with('country')
            ->where('deadline', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return new RecruitmentCollection($recruitments);
    }

    public function show($id)
    {
        $recruitment = Recruitment::with('country')->findOrFail($id);
        return new RecruitmentResource($recruitment);
    }

    public function getByCountry($countryId)
    {
        $recruitments = Recruitment::with('country')
            ->where('country_id', $countryId)
            ->where('deadline', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return new RecruitmentCollection($recruitments);
    }
}
