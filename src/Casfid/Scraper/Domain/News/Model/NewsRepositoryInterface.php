<?php

namespace App\Casfid\Scraper\Domain\News\Model;

interface NewsRepositoryInterface
{
    public function save(News $news): void;
}
