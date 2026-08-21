<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class BrevoService
{
    protected string $apiUrl = 'https://api.brevo.com/v3/smtp/email';

    public function send(
        string $to,
        string $subject,
        string $htmlContent,
        ?string $toName = null
    ): array {

        $response = Http::timeout(10)
            ->withHeaders([
                'accept' => 'application/json',
                'api-key' => config('services.brevo.api_key'),
                'content-type' => 'application/json',
            ])
            ->post($this->apiUrl, [
                'sender' => [
                    'name' => config('services.brevo.from_name'),
                    'email' => config('services.brevo.from_email'),
                ],

                'to' => [
                    [
                        'email' => $to,
                        'name' => $toName,
                    ],
                ],

                'subject' => $subject,

                'htmlContent' => $htmlContent,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Error al enviar correo con Brevo: ' . $response->body()
            );
        }

        return $response->json();
    }
}