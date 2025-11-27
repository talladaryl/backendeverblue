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
     *
     * @param string $prompt The text prompt for image generation
     * @param array $options Additional options (size, quality, style, etc.)
     * @return array
     */
    public function generateImage(string $prompt, array $options = []): array
    {
        try {
            $payload = [
                'prompt' => $prompt,
                'n' => $options['num_images'] ?? 1,
                'size' => $options['size'] ?? '1024x1024',
                'quality' => $options['quality'] ?? 'standard',
                'model' => $options['model'] ?? 'dall-e-3',
            ];

            $response = $this->client->post('images/generations', [
                'json' => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200 && isset($data['data'])) {
                $images = array_map(function ($item) {
                    return $item['url'] ?? $item['b64_json'] ?? null;
                }, $data['data']);

                return [
                    'status' => 'success',
                    'images' => array_filter($images),
                    'created' => $data['created'] ?? null,
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
}
