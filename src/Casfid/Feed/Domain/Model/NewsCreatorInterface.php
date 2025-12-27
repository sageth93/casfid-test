<?php

namespace App\Casfid\Feed\Domain\Model;

interface NewsCreatorInterface
{
    public function add(
        string $id,
        string $title,
        string $content,
        string $author,
        ?\DateTimeInterface $date
    ): void;
}
