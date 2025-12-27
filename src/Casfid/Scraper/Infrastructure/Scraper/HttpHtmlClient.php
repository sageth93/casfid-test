<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper;

use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class HttpHtmlClient
{
    public function __construct(
        protected HttpClientInterface $client
    )
    {
    }

    public function get(string $url): string
    {
        return $this->client->request('GET', $url)->getContent();
    }
}
