<?php

namespace App\Casfid\Scraper\Domain\Source\Event;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceId;
use App\Shared\Domain\Event\AbstractEvent;

class NewPendingSourceEvent extends AbstractEvent
{
    public function __construct(
        protected readonly SourceId $sourceId
    )
    {
        parent::__construct();
    }

    public function sourceId(): SourceId
    {
        return $this->sourceId;
    }
    public function jsonSerialize(): mixed
    {
        return [
            'sourceId' => $this->sourceId()->toString(),
            'occurredOn' => $this->occurredOn(),
        ];
    }
}
