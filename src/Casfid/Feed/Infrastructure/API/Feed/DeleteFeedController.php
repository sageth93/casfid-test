<?php

namespace App\Casfid\Feed\Infrastructure\API\Feed;

use App\Casfid\Feed\Application\News\Command\DeleteNewsById\DeleteNewsByIdCommand;
use App\Shared\Infrastructure\Controller\BaseController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: "Feed")]
class DeleteFeedController extends BaseController
{
    #[Route('/feeds/{id}', name: 'delete_feed', methods: ['DELETE'])]
    #[OA\Parameter(
        name: "id",
        description: "ID of the news to delete",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "string", format: "uuid", example: "123e4567-e89b-12d3-a456-426655440000")
    )]
    #[OA\Response(
        response: 204,
        description: 'Deleted News',
        content: new OA\JsonContent(
            example: null,
            nullable: true
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'News Not Found',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'title', type: 'string', example: 'Not Found'),
                new OA\Property(property: 'status', type: 'int', example: 404),
                new OA\Property(property: 'detail', type: 'string', example: 'News with id 123e4567-e89b-12d3-a456-426655440000 not found')
            ]
        )
    )]
    public function __invoke(
        string $id
    ): JsonResponse
    {
        $this->handle(
            new DeleteNewsByIdCommand($id)
        );

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
