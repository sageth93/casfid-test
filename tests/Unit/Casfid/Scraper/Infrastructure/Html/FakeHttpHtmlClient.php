<?php

namespace App\Tests\Unit\Casfid\Scraper\Infrastructure\Html;

use App\Casfid\Scraper\Infrastructure\Scraper\HttpHtmlClient;

class FakeHttpHtmlClient extends HttpHtmlClient
{
    public function __construct(
        private readonly string $html
    ) {}

    public function get(string $url): string
    {
        return $this->html;
    }
}
