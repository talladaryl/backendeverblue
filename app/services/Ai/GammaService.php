<?php

namespace App\Services\Ai;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class GammaService
{
    protected Client $client;

    protected string $baseUri = 'https://api.gamma.app/v1/';

    public function __construct(
        private string $apiKey,
    ) {
        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'headers'  => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ],
            'timeout' => 30,
        ]);
    }

    /**
     * Generate an image using Gamma API
     *
     * @param string $prompt The text prompt for image generation
     * @param array $options Additional options (size, style, quality, etc.)
     * @return array
     */
    public function generateImage(string $prompt, array $options = []): array
    {
        try {
            $payload = [
                'prompt' => $prompt,
                'size' => $options['size'] ?? '1024x1024',
                'style' => $options['style'] ?? 'realistic',
                'quality' => $options['quality'] ?? 'high',
                'num_images' => $options['num_images'] ?? 1,
            ];

            if (isset($options['negative_prompt'])) {
                $payload['negative_prompt'] = $options['negative_prompt'];
            }

            $response = $this->client->post('images/generate', [
                'json' => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200 && isset($data['images'])) {
                return [
                    'status' => 'success',
                    'images' => $data['images'],
                    'task_id' => $data['task_id'] ?? null,
                    'created_at' => $data['created_at'] ?? now()->toIso8601String(),
                ];
            }

            return [
                'status' => 'error',
                'message' => $data['error']['message'] ?? 'Failed to generate image',
            ];
        } catch (GuzzleException $e) {
            Log::error('Gamma API Error: ' . $e->getMessage());

            return [
                'status' => 'error',
                'message' => 'API request failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get available image styles
     *
     * @return array
     */
    public function getStyles(): array
    {
        try {
            $response = $this->client->get('images/styles');
            $data = json_decode($response->getBody()->getContents(), true);

            return $data['styles'] ?? [];
        } catch (GuzzleException $e) {
            Log::error('Gamma API Error: ' . $e->getMessage());

            return [];
        }
    }

    /**
     * Get available image sizes
     *
     * @return array
     */
    public function getSizes(): array
    {
        return [
            '512x512',
            '768x768',
            '1024x1024',
            '1024x576',
            '576x1024',
        ];
    }

    /**
     * Check generation status
     *
     * @param string $taskId
     * @return array
     */
    public function checkStatus(string $taskId): array
    {
        try {
            $response = $this->client->get("images/status/{$taskId}");
            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'status' => $data['status'] ?? 'unknown',
                'images' => $data['images'] ?? [],
                'progress' => $data['progress'] ?? 0,
            ];
        } catch (GuzzleException $e) {
            Log::error('Gamma API Error: ' . $e->getMessage());

            return [
                'status' => 'error',
                'message' => 'Failed to check status',
            ];
        }
    }

    /**
     * Edit an existing image
     *
     * @param string $imageUrl
     * @param string $prompt
     * @param array $options
     * @return array
     */
    public function editImage(string $imageUrl, string $prompt, array $options = []): array
    {
        try {
            $payload = [
                'image_url' => $imageUrl,
                'prompt' => $prompt,
                'strength' => $options['strength'] ?? 0.7,
            ];

            $response = $this->client->post('images/edit', [
                'json' => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200 && isset($data['images'])) {
                return [
                    'status' => 'success',
                    'images' => $data['images'],
                    'task_id' => $data['task_id'] ?? null,
                ];
            }

            return [
                'status' => 'error',
                'message' => $data['error']['message'] ?? 'Failed to edit image',
            ];
        } catch (GuzzleException $e) {
            Log::error('Gamma API Error: ' . $e->getMessage());

            return [
                'status' => 'error',
                'message' => 'API request failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get user credits/usage
     *
     * @return array
     */
    public function getUsage(): array
    {
        try {
            $response = $this->client->get('user/usage');
            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'credits' => $data['credits'] ?? 0,
                'used' => $data['used'] ?? 0,
                'remaining' => $data['remaining'] ?? 0,
            ];
        } catch (GuzzleException $e) {
            Log::error('Gamma API Error: ' . $e->getMessage());

            return [
                'credits' => 0,
                'used' => 0,
                'remaining' => 0,
            ];
        }
    }
}
