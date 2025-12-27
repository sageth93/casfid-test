<?php

namespace App\Casfid\Feed\Domain\Model;

interface NewsUpdaterInterface
{
    public function update(
        string $id,
        ?string $title,
        ?string $content,
        ?string $author,
        ?\DateTimeInterface $date
    ): void;
}
