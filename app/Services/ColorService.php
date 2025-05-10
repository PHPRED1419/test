<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ColorService
{
    protected $client;

    public function __construct()
{
    $this->client = new Client([
        'base_uri' => 'https://www.thecolorapi.com/',
        'verify' => false, // Disable SSL verification
    ]);
}

    /**
     * Get the color name by its HEX code.
     *
     * @param string $hexCode The HEX color code (e.g., #FF5733).
     * @return string|null The color name or null if not found.
     */
    public function getColorNameByHex($hexCode)
    {
        try {
            $response = $this->client->get('id', [
                'query' => [
                    'hex' => ltrim($hexCode, '#'), // Remove '#' from the HEX code
                ],
            ]);
    
            $data = json_decode($response->getBody(), true);
    
            // Log the API response for debugging
            \Log::info('Color API Response:', $data);
    
            // Check if the 'name' key exists in the response
            if (isset($data['name']['value'])) {
                return $data['name']['value'];
            } else {
                \Log::error('Color name not found in API response.');
                return null;
            }
        } catch (GuzzleException $e) {
            // Handle API errors (e.g., log the error)
            \Log::error('Color API Error: ' . $e->getMessage());
            return null;
        }
    }
}