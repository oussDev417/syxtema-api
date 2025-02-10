<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with(['image', 'country'])
            ->where('status', '1')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return NewsResource::collection($news);
    }

    public function showBySlug($slug)
    {
        try {
            $news = News::where('slug', $slug)
                ->where('status', '1')
                ->with(['image', 'country'])
                ->firstOrFail();
                
            return new NewsResource($news);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Actualité non trouvée'
            ], 404);
        }
    }

    public function getRelated(Request $request)
    {
        $excludeId = $request->query('exclude_id');
        $countryId = $request->query('country_id');

        if (!$excludeId || !$countryId) {
            return response()->json([
                'message' => 'Les paramètres exclude_id et country_id sont requis'
            ], 400);
        }

        try {
            $relatedNews = News::with(['image', 'country'])
                ->where('status', '1')
                ->where('country_id', $countryId)
                ->where('id', '!=', $excludeId)
                ->take(3)
                ->get();

            return NewsResource::collection($relatedNews);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des actualités similaires'
            ], 500);
        }
    }
}