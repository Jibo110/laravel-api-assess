<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LighthouseController extends Controller
{
    public function getPerformanceScore(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'platform' => 'required|in:mobile,desktop',
        ]);

        $url = $request->input('url');
        $platform = $request->input('platform');
        $strategy = $platform === 'mobile' ? 'mobile' : 'desktop';

        $apiUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';
        
        $response = Http::get($apiUrl, [
            'url' => $url,
            'strategy' => $strategy,
            'key' => env('GOOGLE_API_KEY')
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to retrieve performance score'], 500);
        }

        $performanceScore = $response->json('lighthouseResult.categories.performance.score');

        return response()->json([
            'url' => $url,
            'platform' => $platform,
            'performance_score' => $performanceScore * 100 
        ]);
    }
}
