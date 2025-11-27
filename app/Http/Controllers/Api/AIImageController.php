<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AIImage\GenerateImageRequest;
use App\Http\Requests\AIImage\StoreGeneratedImageRequest;
use App\Models\GeneratedImage;
use App\Services\Ai\GammaService;
use App\Services\Ai\OpenAIImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AIImageController extends Controller
{
    public function __construct(
        private GammaService $gammaService,
        private OpenAIImageService $openaiService
    ) {}

    public function versions()
    {
        return response()->json([
            'providers' => [
                'openai' => [
                    'models' => $this->openaiService->getModels(),
                    'sizes' => $this->openaiService->getSizes(),
                    'qualities' => $this->openaiService->getQualities(),
                    'styles' => $this->openaiService->getStyles(),
                ],
                'gamma' => [
                    'versions' => ['gamma-1.0', 'gamma-2.0'],
                    'styles' => [
                        'realistic',
                        'artistic',
                        'cartoon',
                        'abstract',
                        'photorealistic',
                        'oil_painting',
                        'watercolor',
                    ],
                    'sizes' => $this->gammaService->getSizes(),
                    'qualities' => ['low', 'medium', 'high', 'ultra'],
                ],
            ],
        ]);
    }

    public function checkActiveGeneration()
    {
        $activeGenerations = GeneratedImage::where('user_id', Auth::id())
            ->where('status', 'processing')
            ->count();

        return response()->json([
            'isActive' => $activeGenerations > 0,
            'activeCount' => $activeGenerations,
            'progress' => 0,
        ]);
    }

    public function generateImage(StoreGeneratedImageRequest $request)
    {
        try {
            $validated = $request->validated();
            $provider = $validated['provider'] ?? 'openai';

            // Call the appropriate AI service
            $result = match ($provider) {
                'openai' => $this->openaiService->generateImage(
                    $validated['prompt'],
                    [
                        'size' => $validated['size'] ?? '1024x1024',
                        'quality' => $validated['quality'] ?? 'standard',
                        'model' => $validated['model'] ?? 'dall-e-3',
                        'num_images' => $validated['num_images'] ?? 1,
                    ]
                ),
                'gamma' => $this->gammaService->generateImage(
                    $validated['prompt'],
                    [
                        'style' => $validated['style'] ?? 'realistic',
                        'size' => $validated['size'] ?? '1024x1024',
                        'quality' => $validated['quality'] ?? 'high',
                        'num_images' => $validated['num_images'] ?? 1,
                        'negative_prompt' => $validated['negative_prompt'] ?? null,
                    ]
                ),
                default => ['status' => 'error', 'message' => 'Invalid provider'],
            };

            if ($result['status'] === 'error') {
                return response()->json([
                    'status' => 'error',
                    'message' => $result['message'],
                ], 400);
            }

            // Store generated images in database
            $generatedImages = [];
            foreach ($result['images'] as $index => $imageUrl) {
                $generatedImage = GeneratedImage::create([
                    'user_id' => Auth::id(),
                    'event_id' => $validated['event_id'] ?? null,
                    'prompt' => $validated['prompt'],
                    'negative_prompt' => $validated['negative_prompt'] ?? null,
                    'image_url' => $imageUrl,
                    'thumbnail_url' => $imageUrl,
                    'style' => $validated['style'] ?? 'realistic',
                    'size' => $validated['size'] ?? '1024x1024',
                    'quality' => $validated['quality'] ?? 'standard',
                    'task_id' => $result['task_id'] ?? null,
                    'status' => 'completed',
                    'ai_model' => $provider,
                    'metadata' => [
                        'index' => $index,
                        'provider' => $provider,
                        'created_at' => $result['created'] ?? now()->toIso8601String(),
                    ],
                ]);

                $generatedImages[] = $generatedImage;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Images generated successfully',
                'images' => $generatedImages,
                'provider' => $provider,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate image: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getRecentImages(Request $request)
    {
        $limit = $request->query('limit', 10);

        $images = GeneratedImage::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'images' => $images,
            'total' => $images->count(),
        ]);
    }

    public function getImage(GeneratedImage $generatedImage)
    {
        // Check if user owns this image
        if ($generatedImage->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        return response()->json($generatedImage);
    }

    public function deleteImage(GeneratedImage $generatedImage)
    {
        // Check if user owns this image
        if ($generatedImage->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        $generatedImage->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Image deleted successfully',
        ]);
    }

    public function getUserUsage()
    {
        $usage = $this->gammaService->getUsage();

        return response()->json([
            'credits' => $usage['credits'],
            'used' => $usage['used'],
            'remaining' => $usage['remaining'],
        ]);
    }
}
