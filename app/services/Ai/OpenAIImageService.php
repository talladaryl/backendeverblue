<?php

namespace App\Services\Ai;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class OpenAIImageService
{
    protected Client $client;

    protected string $baseUri = 'https://api.openai.com/v1/';

    public function __construct(
        private string $apiKey,
    ) {
        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'headers'  => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'timeout' => 60,
        ]);
    }

    /**
     * Generate an image using OpenAI API
     * Compatible with frontend chatbot
     *
     * @param string $prompt The text prompt for image generation
     * @param array $options Additional options (size, quality, model, etc.)
     * @return array
     */
    public function generateImage(string $prompt, array $options = []): array
    {
        try {
            $model = $options['model'] ?? 'dall-e-3';
            $size = $options['size'] ?? '1024x1024';
            $quality = $options['quality'] ?? 'standard';
            $numImages = $options['num_images'] ?? 1;

            // DALL-E 3 only supports 1 image at a time
            if ($model === 'dall-e-3') {
                $numImages = 1;
            }

            $payload = [
                'prompt' => $prompt,
                'n' => $numImages,
                'size' => $size,
                'quality' => $quality,
                'model' => $model,
                'response_format' => 'url', // Return URL instead of base64
            ];

            $response = $this->client->post('images/generations', [
                'json' => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200 && isset($data['data'])) {
                $images = array_map(function ($item) {
                    return $item['url'] ?? null;
                }, $data['data']);

                return [
                    'status' => 'success',
                    'images' => array_filter($images),
                    'created' => $data['created'] ?? null,
                    'model' => $model,
                ];
            }

            return [
                'status' => 'error',
                'message' => $data['error']['message'] ?? 'Failed to generate image',
            ];
        } catch (GuzzleException $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());

            return [
                'status' => 'error',
                'message' => 'API request failed: ' . $e->getMessage(),
            ];
        } catch (\Exception $e) {
            Log::error('OpenAI Service Error: ' . $e->getMessage());

            return [
                'status' => 'error',
                'message' => 'Service error: ' . $e->getMessage(),
            ];
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
            '1024x1024',
            '1792x1024',
            '1024x1792',
        ];
    }

    /**
     * Get available models
     *
     * @return array
     */
    public function getModels(): array
    {
        return [
            'dall-e-3',
            'dall-e-2',
        ];
    }

    /**
     * Get available qualities
     *
     * @return array
     */
    public function getQualities(): array
    {
        return [
            'standard',
            'hd',
        ];
    }

    /**
     * Get available styles
     *
     * @return array
     */
    public function getStyles(): array
    {
        return [
            'vivid',
            'natural',
        ];
    }

    /**
     * Validate API key
     *
     * @return bool
     */
    public function validateApiKey(): bool
    {
        try {
            $response = $this->client->get('models');
            return $response->getStatusCode() === 200;
        } catch (GuzzleException $e) {
            Log::error('OpenAI API Key Validation Error: ' . $e->getMessage());
            return false;
        }
    }
}
