<?php

namespace App\Casfid\Feed\Infrastructure\API\Feed;

use App\Casfid\Feed\Application\News\Command\UpdateNews\UpdateNewsCommand;
use App\Casfid\Feed\Infrastructure\API\Feed\Request\UpdateFeedRequest;
use App\Shared\Infrastructure\Controller\BaseController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: "Feed")]
class UpdateFeedController extends BaseController
{
    #[Route('/feeds/{id}', name: 'update_feed', methods: ['PUT'])]
    #[OA\Parameter(
        name: "id",
        description: "ID of the news to update",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "string", format: "uuid", example: "123e4567-e89b-12d3-a456-426655440000")
    )]
    #[OA\Response(
        response: 204,
        description: 'News Updated',
        content: new OA\JsonContent(
            example: null,
            nullable: true
        )
    )]
    #[OA\Response(
        response: 422,
        description: 'Unprocessable Content',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'title', type: 'string', example: 'Unprocessable Content'),
                new OA\Property(property: 'status', type: 'int', example: 422),
                new OA\Property(property: 'detail', type: 'string', example: 'Title is required')
            ]
        )
    )]
    #[OA\Response(
        response: 409,
        description: 'News already exists',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'title', type: 'string', example: 'Conflict'),
                new OA\Property(property: 'status', type: 'int', example: 409),
                new OA\Property(property: 'detail', type: 'string', example: 'News with id 123e4567-e89b-12d3-a456-426655440000 already exists')
            ]
        )
    )]
    public function __invoke(
        string $id,
        #[MapRequestPayload] UpdateFeedRequest $request
    ): JsonResponse
    {
        $this->handle(
            new UpdateNewsCommand(
                id: $id,
                title: $request->title,
                content: $request->content,
                author: $request->author,
                date: $request->date
            )
        );

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
