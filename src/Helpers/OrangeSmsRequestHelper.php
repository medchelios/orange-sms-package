<?php

namespace Tmoh\OrangeSmsPackage\Helpers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class OrangeSmsRequestHelper {
    /**
     * @throws ConnectionException
     */
    public static function postToken(string $url): array {
        $basicToken = config('orange_sms.basic_token');

        $response = Http::timeout(30)
            ->asForm()
            ->withHeaders([
                'Authorization' => 'Basic ' . $basicToken
            ])
            ->post($url, [
                'grant_type' => 'client_credentials'
            ]);

        if ($response->successful()) {
            $result = $response->json();
            return [
                'success' => true,
                'data' => $result,
                'error' => null
            ];
        }

        return [
            'success' => false,
            'data' => null,
            'error' => 'Authentication error: ' . $response->body()
        ];
    }

    /**
     * @throws ConnectionException
     */
    public static function postWithAuth(string $url, array $data, string $accessToken): array {
        $response = Http::timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken
            ])
            ->post($url, $data);

        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $response->json(),
                'error' => null
            ];
        }

        return [
            'success' => false,
            'data' => null,
            'error' => $response->json(),
            'status_code' => $response->status()
        ];
    }

    /**
     * @throws ConnectionException
     */
    public static function getWithAuth(string $url, array $params, string $accessToken): array {
        $response = Http::timeout(30)
            ->withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken
            ])
            ->get($url, $params);

        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $response->json(),
                'error' => null
            ];
        }

        return [
            'success' => false,
            'data' => null,
            'error' => $response->json(),
            'status_code' => $response->status()
        ];
    }
}
