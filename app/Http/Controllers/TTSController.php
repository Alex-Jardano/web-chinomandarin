<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TTSController extends Controller
{
    public function speak(Request $request)
    {
        $text = $request->query('text');
        $lang = $request->query('lang', 'zh-CN');

        if (!$text) {
            return response()->json(['error' => 'No text provided'], 400);
        }

        $cacheKey = 'tts_' . md5($text . $lang);

        try {
            $audio = Cache::remember($cacheKey, 3600, function () use ($text, $lang) {
                $url = 'https://translate.google.com/translate_tts?ie=UTF-8&tl=' . urlencode($lang) . '&client=tw-ob&q=' . urlencode($text);

                $response = Http::timeout(10)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                    ])
                    ->get($url);

                if ($response->failed()) {
                    throw new \Exception('Failed to fetch audio from Google TTS');
                }

                return $response->body();
            });

            return response($audio)
                ->header('Content-Type', 'audio/mpeg')
                ->header('Cache-Control', 'public, max-age=3600');

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
