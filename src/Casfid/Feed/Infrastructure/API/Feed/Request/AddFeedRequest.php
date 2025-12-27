<?php

namespace App\Casfid\Feed\Infrastructure\API\Feed\Request;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

class AddFeedRequest
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[OA\Property(
        description: "Unique identifier for the news",
        type: "string",
        format: "uuid",
        example: "123e4567-e89b-12d3-a456-426655440000"
    )]
    public string $id;

    #[Assert\Length(min: 3)]
    #[Assert\Length(max: 100)]
    #[OA\Property(
        description: "Title of the news",
        type: "string",
        example: "What is Lorem Ipsum?"
    )]
    public string $title;

    #[Assert\Length(min: 3)]
    #[OA\Property(
        description: "Content of the news",
        type: "string",
        example: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
    )]
    public string $content;

    #[Assert\Length(min: 3)]
    #[Assert\Length(max: 100)]
    #[OA\Property(
        description: "Author of the news",
        type: "string",
        example: "Cicero"
    )]
    public string $author;

    #[Assert\Type(\DateTimeInterface::class)]
    #[OA\Property(
        description: "Date when News was published",
    )]
    public ?\DateTimeInterface $date;
    public function __construct(
        string $title,
        string $content,
        string $author,
        ?\DateTimeInterface $date
    )
    {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->date = $date;
    }
}
