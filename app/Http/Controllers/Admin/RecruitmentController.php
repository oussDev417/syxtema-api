<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recruitment;
use App\Models\Country;
use App\Services\RecruitmentService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRecruitmentRequest;

class RecruitmentController extends Controller
{
    protected $recruitmentService;

    public function __construct(RecruitmentService $recruitmentService)
    {
        $this->recruitmentService = $recruitmentService;
    }

    public function index()
    {
        $recruitments = $this->recruitmentService->getAll();
        return view('admin.recruitments.index', compact('recruitments'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.recruitments.create', compact('countries'));
    }   
                                                                                    

    public function store(StoreRecruitmentRequest $request)
    {
        $this->recruitmentService->create($request->validated());
        return redirect()->route('admin.recruitments.index')->with('success', 'Offre créée avec succès.');
    }

    public function edit($id)
    {
        $recruitment = Recruitment::findOrFail($id);
        return view('admin.recruitments.edit', compact('recruitment'));
    }

    public function update(StoreRecruitmentRequest $request, $id)
    {
        $recruitment = Recruitment::findOrFail($id);
        $this->recruitmentService->update($recruitment, $request->validated());
        return redirect()->route('admin.recruitments.index')->with('success', 'Offre mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $recruitment = Recruitment::findOrFail($id);
        $this->recruitmentService->delete($recruitment);
        return redirect()->route('admin.recruitments.index')->with('success', 'Offre supprimée avec succès.');
    }
}
