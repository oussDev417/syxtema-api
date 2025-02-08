<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PartnerResource;
use App\Services\PartnerService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PartnerController extends Controller
{
    public function __construct(private PartnerService $partnerService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $partners = $this->partnerService->getAll();
        return PartnerResource::collection($partners);
    }

    public function show($id)
    {
        $partner = $this->partnerService->find($id);
        return new PartnerResource($partner);
    }
}